<?php

namespace App\Http\Controllers;

use App\Enums\QuizStatus;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\SubmitQuizRequest;
use App\Models\Concept;
use App\Models\Domain;
use App\Models\Quiz;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    protected GroqService $groq;

    public function __construct(GroqService $groq)
    {
        $this->groq = $groq;
    }

    public function create()
    {
        $domains = Auth::user()->domains()->with('concepts')->get();

        $domains = $domains->map(function ($domain) {
            $domain->allConcepts = $domain->concepts->map(function ($c) {
                $c->quizStatus = $c->getQuizStatus();
                $c->quizMessage = $c->getQuizMessage();
                return $c;
            });
            $domain->quizReadyConcepts = $domain->allConcepts->filter(fn ($c) => $c->quizStatus === 'ready');
            $domain->quizReadyCount = $domain->quizReadyConcepts->count();
            $domain->totalConcepts = $domain->concepts->count();
            $domain->canQuiz = $domain->quizReadyCount >= (config('quiz.domain.min_ready_concepts') ?? 3);
            return $domain;
        });

        return view('quizzes.create', compact('domains'));
    }

    public function store(StoreQuizRequest $request)
    {
        $domain = Domain::findOrFail($request->domain_id);
        $conceptIds = $request->concept_ids;
        $concepts = Concept::whereIn('id', $conceptIds)->get();

        $questionCount = min(max(count($concepts) * (config('quiz.questions.per_concept') ?? 3), config('quiz.questions.min_per_quiz') ?? 10), config('quiz.questions.max_per_quiz') ?? 15);
        $timeLimit = max(round($questionCount * (config('quiz.timer.minutes_per_question') ?? 1.5)), config('quiz.timer.min_minutes') ?? 10);

        try {
            $questions = $this->groq->generateQuizQuestions($domain, $concepts);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate quiz questions. Please try again.');
        }

        $quiz = DB::transaction(function () use ($domain, $concepts, $questions, $questionCount, $timeLimit) {
            $quiz = Auth::user()->quizzes()->create([
                'domain_id' => $domain->id,
                'time_limit_minutes' => $timeLimit,
                'started_at' => now(),
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

            return $quiz;
        });

        session(['quiz_domain_' . $quiz->id => $domain->name]);
        session()->flash('quiz_created', true);

        return redirect()->route('quizzes.active', ['domain' => $domain, 'quiz' => $quiz]);
    }

    public function byDomain(Domain $domain)
    {
        if ($domain->user_id !== Auth::id()) {
            abort(403);
        }

        $quizzes = Auth::user()->quizzes()
            ->where('domain_id', $domain->id)
            ->with('domain')
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('quizzes.by-domain', compact('domain', 'quizzes'));
    }

    public function active(Domain $domain, Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id() || $quiz->domain_id !== $domain->id) {
            abort(403);
        }

        if ($quiz->status !== QuizStatus::InProgress || $quiz->passed) {
            return redirect()->route('quizzes.results', $quiz);
        }

        $timeExpired = $quiz->started_at && $quiz->started_at->diffInSeconds(now()) >= ($quiz->time_limit_minutes * 60);

        $quiz->load(['questions' => fn ($q) => $q->orderBy('sort_order'), 'questions.concept']);
        $domainName = session('quiz_domain_' . $quiz->id, $quiz->domain->name);

        return view('quizzes.active-quiz', compact('quiz', 'domain', 'domainName', 'timeExpired'));
    }

    public function submit(SubmitQuizRequest $request, Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        if ($quiz->status === QuizStatus::Submitted) {
            return redirect()->route('quizzes.results', $quiz);
        }

        $questions = $quiz->questions()->with('concept')->orderBy('sort_order')->get();
        $maxScore = $questions->count() * 5;

        $grouped = $questions->groupBy(fn ($q) => $q->concept_id);

        $evaluationsByQuestion = collect();

        foreach ($grouped as $conceptQuestions) {
            $concept = $conceptQuestions->first()->concept;
            if (!$concept) continue;

            $qaPairs = [];
            foreach ($conceptQuestions as $q) {
                $qaPairs[] = [
                    'question_id' => $q->id,
                    'question' => $q->question,
                    'answer' => $request->validated()['answers'][$q->sort_order] ?? '',
                ];
            }

            $evaluations = [];
            try {
                $evaluations = $this->groq->evaluateAnswers($concept, $qaPairs);
            } catch (\Exception $e) {
                Log::warning('Quiz AI evaluation failed for concept #' . ($concept->id ?? '?') . ' in quiz #' . $quiz->id . ': ' . $e->getMessage());
            }

            foreach ($evaluations as $eval) {
                $idx = $eval['question_index'] ?? null;
                if ($idx !== null && isset($qaPairs[$idx])) {
                    $evaluationsByQuestion->put($qaPairs[$idx]['question_id'], $eval);
                }
            }
        }

        DB::transaction(function () use ($questions, $request, $evaluationsByQuestion, $maxScore, $quiz) {
            $totalScore = 0;

            foreach ($questions as $q) {
                $eval = $evaluationsByQuestion->get($q->id);

                if ($eval) {
                    $rating = $eval['rating'] ?? 1;
                    $update = [
                        'answer' => $request->answers[$q->sort_order] ?? '',
                        'rating' => $rating,
                        'feedback' => $eval['feedback'] ?? null,
                        'model_answer' => $eval['model_answer'] ?? null,
                    ];
                } else {
                    $rating = $request->ratings[$q->sort_order] ?? 1;
                    $update = [
                        'answer' => $request->answers[$q->sort_order] ?? '',
                        'rating' => $rating,
                        'feedback' => 'Evaluation unavailable.',
                        'model_answer' => null,
                    ];
                }

                $q->update($update);
                $totalScore += $rating;
            }

            $quiz->update([
                'total_score' => $totalScore,
                'max_score' => $maxScore,
                'submitted_at' => now(),
                'status' => QuizStatus::Submitted,
                'passed' => true,
            ]);
        });

        return redirect()->route('quizzes.results', $quiz);
    }

    public function results(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

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
}
