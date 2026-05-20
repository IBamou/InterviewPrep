<?php

namespace App\Http\Controllers;

use App\Enums\QuizStatus;
use App\Http\Requests\StoreQuizRequest;
use App\Models\Domain;
use App\Models\Quiz;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    protected AiService $ai;

    public function __construct(AiService $ai)
    {
        $this->ai = $ai;
    }

    public function index()
    {
        $domains = Auth::user()->domains()->with('concepts')->get();

        $domains = $domains->map(function ($domain) {
            $domain = $this->loadDomainQuizData($domain);
            $domain->quotaRemaining = $this->getQuotaRemaining($domain);
            return $domain;
        });

        $quotaLimit = config('quiz.quota.per_domain_per_day');

        return view('quizzes.index', compact('domains', 'quotaLimit'));
    }

    public function store(StoreQuizRequest $request)
    {
        $domain = $request->user()->domains()->findOrFail($request->domain_id);
        $conceptIds = $request->concept_ids;
        $concepts = $domain->concepts()->whereIn('id', $conceptIds)->get();

        if ($concepts->isEmpty()) {
            return back()->with('error', 'No valid concepts found for this quiz.');
        }

        $questionCount = min(max(count($concepts) * config('quiz.questions.per_concept'), config('quiz.questions.min_per_quiz')), config('quiz.questions.max_per_quiz'));
        $timeLimit = max(round($questionCount * config('quiz.timer.minutes_per_question')), config('quiz.timer.min_minutes'));

        try {
            $questions = $this->ai->generateQuizQuestions($domain, $concepts, $questionCount);
        } catch (\Exception $e) {
            Log::warning('QuizController::store - AI generation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate quiz questions. Please try again.');
        }

        $quiz = DB::transaction(function () use ($domain, $timeLimit, $questions, $concepts) {
            $quiz = Auth::user()->quizzes()->create([
                'domain_id' => $domain->id,
                'time_limit_minutes' => $timeLimit,
                'status' => QuizStatus::InProgress,
            ]);

            foreach ($questions as $i => $q) {
                $matchingConcept = $concepts->first(function ($c) use ($q) {
                    return strtolower(trim($c->title)) === strtolower(trim($q['concept'] ?? ''));
                });

                $quiz->questions()->create([
                    'concept_id' => $matchingConcept?->id ?? $concepts->first()->id,
                    'question' => $q['question'],
                    'sort_order' => $i,
                ]);
            }

            $quiz->update(['started_at' => now()]);

            return $quiz;
        });

        session(['quiz_domain_' . $quiz->id => $domain->name]);

        return redirect()->route('quizzes.active', ['domain' => $domain, 'quiz' => $quiz]);
    }

    public function destroy(Quiz $quiz)
    {
        $this->authorize('delete', $quiz);

        $domain = $quiz->domain;

        $quiz->delete();

        return redirect()->route('quizzes.byDomain', $domain);
    }

    public function byDomain(Domain $domain)
    {
        $this->authorize('view', $domain);

        $domain->load('concepts');

        $this->loadDomainQuizData($domain, withAvgRating: true);

        $quotaRemaining = $this->getQuotaRemaining($domain);
        $quotaLimit = config('quiz.quota.per_domain_per_day');

        return view('quizzes.by-domain', compact('domain', 'quotaRemaining', 'quotaLimit'));
    }

    public function domainHistory(Domain $domain)
    {
        $this->authorize('view', $domain);

        $quizzes = Auth::user()->quizzes()
            ->where('domain_id', $domain->id)
            ->with('domain')
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('quizzes.domain-history', compact('domain', 'quizzes'));
    }

    public function active(Domain $domain, Quiz $quiz)
    {
        $this->authorize('view', $quiz);

        if ($quiz->domain_id !== $domain->id) {
            abort(404);
        }

        if ($quiz->status !== QuizStatus::InProgress || $quiz->passed) {
            return redirect()->route('quizzes.results', $quiz);
        }

        $timeExpired = $quiz->started_at && $quiz->started_at->diffInSeconds(now()) >= ($quiz->time_limit_minutes * 60);

        $quiz->load(['questions' => fn ($q) => $q->orderBy('sort_order'), 'questions.concept']);
        $domainName = session('quiz_domain_' . $quiz->id, $quiz->domain->name);

        return view('quizzes.active-quiz', compact('quiz', 'domain', 'domainName', 'timeExpired'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        if ($quiz->status !== QuizStatus::InProgress) {
            return redirect()->route('quizzes.results', $quiz);
        }

        $mode = $request->input('mode');
        $answers = $request->input('answers', []);

        return match ($mode) {
            'submit' => $this->handleSubmit($quiz, $answers),
            'timeup' => $this->handleTimeup($quiz, $answers),
            'end'    => $this->handleEnd($quiz, $answers),
            default  => back()->with('error', 'Invalid completion mode.'),
        };
    }

    private function handleSubmit(Quiz $quiz, array $answers)
    {
        $totalQuestions = $quiz->questions()->count();
        $answeredCount = collect($answers)->filter(fn ($a) => trim($a ?? ''))->count();

        $minRequired = max(ceil($totalQuestions / 3), 1);

        if ($answeredCount < $minRequired) {
            return back()->with('error', "You must answer at least {$minRequired} of {$totalQuestions} questions before submitting.");
        }

        $this->evaluateAndSubmitQuiz($quiz, $answers);
        $quiz->update(['passed' => true]);

        return redirect()->route('quizzes.results', $quiz);
    }

    private function handleTimeup(Quiz $quiz, array $answers)
    {
        $hasAnswers = collect($answers)->filter(fn ($a) => trim($a ?? ''))->isNotEmpty();

        if ($hasAnswers) {
            $this->evaluateAndSubmitQuiz($quiz, $answers);
            $quiz->update(['passed' => true]);
        } else {
            DB::transaction(function () use ($quiz) {
                $maxScore = $quiz->questions()->count() * config('quiz.scoring.max_per_question');

                $quiz->update([
                    'total_score' => 0,
                    'max_score' => $maxScore,
                    'submitted_at' => now(),
                    'status' => QuizStatus::Submitted,
                    'passed' => true,
                ]);
            });
        }

        return redirect()->route('quizzes.results', $quiz);
    }

    private function handleEnd(Quiz $quiz, array $answers)
    {
        $domainId = $quiz->domain_id;

        DB::transaction(function () use ($quiz, $answers) {
            foreach ($quiz->questions()->orderBy('sort_order')->get() as $q) {
                $answerText = $answers[$q->sort_order] ?? '';
                $q->update([
                    'answer' => $answerText,
                    'rating' => 0,
                    'feedback' => 'Quiz ended early — no AI evaluation.',
                    'model_answer' => null,
                ]);
            }

            $maxScore = $quiz->questions()->count() * config('quiz.scoring.max_per_question');

            $quiz->update([
                'total_score' => 0,
                'max_score' => $maxScore,
                'submitted_at' => now(),
                'status' => QuizStatus::Submitted,
                'passed' => true,
            ]);
        });

        $domain = Domain::withTrashed()->find($domainId);

        if ($domain) {
            return redirect()->route('quizzes.byDomain', $domain);
        }

        return redirect()->route('quizzes.index');
    }

    private function evaluateAndSubmitQuiz(Quiz $quiz, array $answers): void
    {
        $questions = $quiz->questions()->with('concept')->orderBy('sort_order')->get();
        $maxScore = $questions->count() * config('quiz.scoring.max_per_question');

        $grouped = $questions->groupBy(fn ($q) => $q->concept_id);
        $batches = [];

        foreach ($grouped as $conceptQuestions) {
            $concept = $conceptQuestions->first()->concept;
            if (!$concept) continue;

            $qaPairs = [];
            foreach ($conceptQuestions as $q) {
                $answerText = $answers[$q->sort_order] ?? '';
                if (trim($answerText)) {
                    $qaPairs[] = [
                        'question_id' => $q->id,
                        'question' => $q->question,
                        'answer' => $answerText,
                    ];
                }
            }

            if (!empty($qaPairs)) {
                $batches[] = [
                    'concept' => $concept,
                    'qa_pairs' => $qaPairs,
                ];
            }
        }

        $evaluationsByQuestion = collect();
        if (!empty($batches)) {
            try {
                $results = $this->ai->evaluateAnswersBatch($batches);
                foreach ($results as $questionId => $eval) {
                    $evaluationsByQuestion->put($questionId, $eval);
                }
            } catch (\Exception $e) {
                Log::warning('Quiz AI batch evaluation failed for quiz #' . $quiz->id . ': ' . $e->getMessage());
            }
        }

        DB::transaction(function () use ($questions, $answers, $evaluationsByQuestion, $maxScore, $quiz) {
            $totalScore = 0;

            foreach ($questions as $q) {
                $answerText = $answers[$q->sort_order] ?? '';

                if (trim($answerText)) {
                    $eval = $evaluationsByQuestion->get($q->id);

                    if ($eval) {
                        $rating = $eval['rating'] ?? 1;
                        $update = [
                            'answer' => $answerText,
                            'rating' => $rating,
                            'feedback' => $eval['feedback'] ?? null,
                            'model_answer' => $eval['model_answer'] ?? null,
                        ];
                    } else {
                        $update = [
                            'answer' => $answerText,
                            'rating' => 1,
                            'feedback' => 'Evaluation unavailable.',
                            'model_answer' => null,
                        ];
                    }

                    $totalScore += $update['rating'];
                } else {
                    $update = [
                        'answer' => '',
                        'rating' => 0,
                        'feedback' => 'Not answered.',
                        'model_answer' => null,
                    ];
                }

                $q->update($update);
            }

            $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

            $quiz->update([
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'submitted_at' => now(),
                'status' => QuizStatus::Submitted,
                'passed' => $percentage >= config('quiz.passing_threshold'),
            ]);
        });
    }

    public function results(Quiz $quiz)
    {
        $this->authorize('view', $quiz);

        $quiz->load(['questions' => fn ($q) => $q->orderBy('sort_order'), 'questions.concept', 'domain']);
        $domainName = session('quiz_domain_' . $quiz->id, $quiz->domain->name);
        $percentage = $quiz->max_score > 0 ? round(($quiz->total_score / $quiz->max_score) * 100, 1) : 0;
        $durationMinutes = $quiz->started_at && $quiz->submitted_at ? $quiz->started_at->diffInMinutes($quiz->submitted_at) : null;

        return view('quizzes.results', compact('quiz', 'domainName', 'percentage', 'durationMinutes'));
    }

    public function history(Request $request)
    {
        $query = Auth::user()->quizzes()->with('domain')->withCount('questions');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quizzes = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('quizzes.history', compact('quizzes'));
    }

    private function loadDomainQuizData(Domain $domain, bool $withAvgRating = false): Domain
    {
        $domain->allConcepts = $domain->concepts->map(function ($c) use ($withAvgRating) {
            $c->quizStatus = $c->getQuizStatus();
            $c->quizMessage = $c->getQuizMessage();
            if ($withAvgRating) {
                $c->avgRating = $c->getGlobalAvgRating();
            }
            return $c;
        });
        $domain->quizReadyConcepts = $domain->allConcepts->filter(fn ($c) => $c->quizStatus === 'ready');
        $domain->quizReadyCount = $domain->quizReadyConcepts->count();
        $domain->totalConcepts = $domain->concepts->count();
        $domain->canQuiz = $domain->quizReadyCount >= config('quiz.domain.min_ready_concepts');
        return $domain;
    }

    private function getQuotaRemaining(Domain $domain): int
    {
        $quota = config('quiz.quota.per_domain_per_day');
        $recentCount = Auth::user()->quizzes()
            ->where('domain_id', $domain->id)
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        return max(0, $quota - $recentCount);
    }
}
