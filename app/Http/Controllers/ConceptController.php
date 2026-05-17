<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Domain;
use App\Models\GeneratedQuestion;
use App\Services\GroqService;
use App\Services\ProgressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConceptController extends Controller
{
    public function create(Domain $domain)
    {
        $this->authorize('view', $domain);

        return view('concepts.create', compact('domain'));
    }

    public function verifyTitle(Request $request, Domain $domain, GroqService $groq)
    {
        $this->authorize('view', $domain);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
        ]);

        try {
            $result = $groq->verifyConceptTitle($data['title'], $domain->name);
            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => 'Failed to verify title: ' . $e->getMessage()], 500);
        }
    }

    public function generateExplanation(Request $request, Domain $domain, GroqService $groq)
    {
        $this->authorize('view', $domain);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
        ]);

        try {
            $result = $groq->generateConceptExplanation($data['title'], $domain->name);

            if (isset($result['error']) && $result['error'] === 'invalid') {
                return response()->json(['error' => $result['message']], 422);
            }

            return response()->json(['explanation' => $result['explanation']]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => 'Failed to generate explanation: ' . $e->getMessage()], 500);
        }
    }

    public function store(StoreConceptRequest $request, Domain $domain, ProgressionService $progression)
    {
        $this->authorize('view', $domain);

        $validated = $request->validated();
        $validated['domain_id'] = $domain->id;
        $validated['status'] = Status::ToReview;

        $concept = Concept::create($validated);

        if (!empty(trim($validated['explanation'] ?? ''))) {
            $progression->awardExplanationXp($concept);
        }

        return redirect()->route('domains.show', $domain)->with('success', 'Concept created successfully.');
    }

    public function show(Concept $concept, ProgressionService $progression)
    {
        $this->authorize('view', $concept);

        $concept->load([
            'domain' => function ($query) {
                $query->withCount('concepts');
            },
            'generatedQuestions',
        ]);

        $questionSets = $concept->generatedQuestions
            ->groupBy('tier')
            ->map(function ($tierQuestions) {
                return $tierQuestions->groupBy('set_number')->sortKeys();
            });

        $tiers = config('gamification.tiers');
        $tierData = [];
        foreach ($tiers as $tier) {
            $tierData[$tier] = $questionSets->get($tier, collect());
        }

        $nextUnlock = $progression->getNextUnlockThreshold($concept);
        $masteryProgress = $progression->getMasteryProgress($concept);
        $isFirstSetEver = $progression->isFirstSetEver($concept);

        $tierProgress = [];
        foreach ($tiers as $tier) {
            $tierXP = $concept->getTierXp($tier);
            $tierSets = $tierData[$tier] ?? collect();
            $unlocked = $concept->hasTierUnlocked($tier);

            $targetXp = $tier === 'mid' ? config('gamification.mid_unlock_xp') : ($tier === 'senior' ? config('gamification.senior_unlock_xp') : 200);

            $tierProgress[$tier] = [
                'unlocked' => $unlocked,
                'xp' => $tierXP,
                'xp_target' => $targetXp,
                'avg_rating' => $concept->getTierAvgRating($tier),
                'set_count' => $tierSets->count(),
            ];
        }

        return view('concepts.show', compact('concept', 'tierData', 'tiers', 'nextUnlock', 'masteryProgress', 'isFirstSetEver', 'tierProgress'));
    }

    public function practice(Concept $concept, Request $request)
    {
        $this->authorize('view', $concept);

        $concept->load('domain');

        $allQuestions = $concept->generatedQuestions()
            ->orderBy('set_number')
            ->orderBy('id')
            ->get()
            ->groupBy('tier');

        $tier = $request->query('tier', 'junior');
        $tierQuestions = $allQuestions->get($tier, collect());
        $questionSets = $tierQuestions->groupBy('set_number');

        $setNumbers = $questionSets->keys()->values()->toArray();
        $totalPages = max(1, count($setNumbers));
        $currentPage = (int) $request->query('page', 1);
        $currentPage = min(max(1, $currentPage), $totalPages);

        $currentSetNumber = $setNumbers[$currentPage - 1] ?? null;
        $currentSet = $currentSetNumber ? $questionSets->get($currentSetNumber) : collect();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentSetNumber ? [$currentSetNumber => $currentSet] : [],
            $totalPages,
            1,
            $currentPage,
            ['path' => $request->url()]
        );

        $allTiers = config('gamification.tiers');
        $tierMetadata = [];
        foreach ($allTiers as $t) {
            $tierQuestions = $allQuestions->get($t, collect());
            $sets = [];
            foreach ($tierQuestions->groupBy('set_number') as $setNum => $questions) {
                $evaluated = $questions->whereNotNull('rating')->count();
                $total = $questions->count();
                $sets[] = [
                    'number' => $setNum,
                    'evaluated' => $evaluated,
                    'total' => $total,
                    'status' => $evaluated === 0 ? 'not_started' : ($evaluated < $total ? 'in_progress' : 'completed'),
                ];
            }
            $tierMetadata[$t] = [
                'unlocked' => $concept->hasTierUnlocked($t),
                'setCount' => count($sets),
                'sets' => $sets,
            ];
        }

        return view('concepts.practice', compact('concept', 'questionSets', 'currentSet', 'currentSetNumber', 'paginator', 'totalPages', 'setNumbers', 'tier', 'tierMetadata', 'allTiers'));
    }

    public function edit(Concept $concept)
    {
        $this->authorize('update', $concept);

        $concept->load('domain');

        return view('concepts.edit', compact('concept'));
    }

    public function update(UpdateConceptRequest $request, Concept $concept, ProgressionService $progression)
    {
        $this->authorize('update', $concept);

        $hasExplanation = !empty(trim($request->validated()['explanation'] ?? ''));
        $previouslyEmpty = empty(trim($concept->explanation ?? ''));

        $concept->update($request->validated());

        if ($hasExplanation && $previouslyEmpty) {
            $progression->awardExplanationXp($concept);
        }

        return redirect()->route('concepts.show', $concept)->with('success', 'Concept updated successfully.');
    }

    public function archive(Concept $concept)
    {
        $this->authorize('delete', $concept);

        $concept->delete();

        return redirect()->route('domains.show', $concept->domain_id)->with('success', 'Concept archived successfully.');
    }

    public function restore(Concept $concept)
    {
        $this->authorize('restore', $concept);

        $concept->restore();

        return back()->with('success', 'Concept restored successfully.');
    }

    public function forceDelete(Concept $concept)
    {
        $this->authorize('forceDelete', $concept);

        $concept->forceDelete();

        return redirect()->route('concepts.archives', $concept->domain_id)->with('success', 'Concept permanently deleted.');
    }

    public function generateQuestions(Concept $concept, GroqService $groq)
    {
        $this->authorize('view', $concept);

        $concept->load('domain');

        if (!$concept->domain_id || !$concept->domain) {
            return back()->with('error', 'Cannot generate questions: this concept is not linked to a domain.');
        }

        try {
            $questions = $groq->generateQuestions($concept, Auth::user());

            if (isset($questions['error']) && $questions['error'] === 'unrelated') {
                return back()->with('error', $questions['message'] ?? 'The concept is not relevant to this domain.');
            }

            $maxSet = $concept->generatedQuestions()->max('set_number') ?? 0;
            $setNumber = $maxSet + 1;
            $tier = $concept->getHighestUnlockedTier();

            foreach ($questions as $question) {
                GeneratedQuestion::create([
                    'concept_id' => $concept->id,
                    'question' => $question,
                    'set_number' => $setNumber,
                    'tier' => $tier,
                ]);
            }

            return redirect(route('concepts.practice', $concept) . '?page=' . $setNumber)
                ->with('success', "Set {$setNumber}: 5 interview questions generated successfully.");
        } catch (\RuntimeException $e) {
            return back()->with('error', 'Failed to generate questions: ' . $e->getMessage());
        }
    }

    public function submitAnswers(Request $request, Concept $concept, GroqService $groq, ProgressionService $progression)
    {
        $this->authorize('view', $concept);

        $concept->load('domain');

        if (!$concept->domain_id || !$concept->domain) {
            return back()->with('error', 'Cannot evaluate answers: this concept is not linked to a domain.');
        }

        $data = $request->validate([
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => [
                'required',
                'exists:generated_questions,id',
                function ($attribute, $value, $fail) use ($concept) {
                    if (!GeneratedQuestion::where('id', $value)->where('concept_id', $concept->id)->exists()) {
                        $fail('Invalid question ID provided.');
                    }
                },
            ],
            'answers.*.answer' => 'nullable|string|max:10000',
        ]);

        try {
            $questionIds = collect($data['answers'])->pluck('question_id')->toArray();
            $questions = GeneratedQuestion::whereIn('id', $questionIds)->get()->keyBy('id');

            $qaPairs = [];
            foreach ($data['answers'] as $item) {
                $question = $questions->get($item['question_id']);
                if (!$question) {
                    continue;
                }
                $question->update(['answer' => $item['answer'] ?? '']);
                $qaPairs[] = [
                    'question_id' => $item['question_id'],
                    'question' => $question->question,
                    'answer' => $item['answer'] ?? '',
                ];
            }

            $evaluations = $groq->evaluateAnswers($concept, $qaPairs);

            $firstQuestion = $questions->first();
            $tier = $firstQuestion ? $firstQuestion->tier : 'junior';

            $isFirstToday = $progression->isFirstPracticeToday($concept);
            $streakBonus = $progression->getStreakBonus($concept);

            $totalXp = 0;
            $totalRating = 0;
            $ratedCount = 0;
            $tierRatingSum = 0;
            $tierRatingCount = 0;
            $firstGq = $questions->first();
            $submittedSetNumber = $firstGq ? $firstGq->set_number : null;
            foreach ($evaluations as $eval) {
                $idx = $eval['question_index'] ?? null;
                if ($idx !== null && isset($qaPairs[$idx])) {
                    $gq = $questions->get($qaPairs[$idx]['question_id']);
                    if ($gq) {
                        $gq->update([
                            'rating' => $eval['rating'] ?? null,
                            'feedback' => $eval['feedback'] ?? null,
                            'model_answer' => $eval['model_answer'] ?? null,
                        ]);

                        if ($eval['rating'] !== null) {
                            $totalXp += $progression->calculateXpForRating($eval['rating']) + $streakBonus;
                            $totalRating += $eval['rating'];
                            $ratedCount++;
                            $tierRatingSum += $eval['rating'];
                            $tierRatingCount++;
                        }
                    }
                }
            }

            $isPerfectSet = $progression->isPerfectSet($evaluations);
            $bonusXp = 0;
            if ($isFirstToday) {
                $bonusXp += config('gamification.bonus_first_today');
            }
            if ($isPerfectSet) {
                $bonusXp += config('gamification.bonus_perfect_set');
            }

            if ($submittedSetNumber !== null && $progression->hasRatingImproved($concept, $tier, $submittedSetNumber, $evaluations)) {
                $bonusXp += config('gamification.bonus_rating_improvement');
                $ratingImproved = true;
            } else {
                $ratingImproved = false;
            }

            $totalXp += $bonusXp;

            $progression->updateStreak($concept);
            $milestoneXp = $progression->checkStreakMilestone($concept);
            $totalXp += $milestoneXp;

            $concept = $progression->awardXp($concept, $totalXp, $tier);
            $masteryScore = $progression->calculateMasteryScore($concept);
            $concept->update(['mastery_score' => $masteryScore]);

            $avgRating = $ratedCount > 0 ? $totalRating / $ratedCount : 0;
            $sessions = $concept->practice_sessions ?? [];
            $sessions[] = [
                'date' => now()->toDateString(),
                'avg_rating' => $avgRating,
                'xp_gained' => $totalXp,
            ];
            $concept->update(['practice_sessions' => $sessions]);

            $tierRatings = $concept->tier_ratings ?? config('gamification.default_tier_ratings');
            $tierRatings[$tier]['sum'] = ($tierRatings[$tier]['sum'] ?? 0) + $tierRatingSum;
            $tierRatings[$tier]['count'] = ($tierRatings[$tier]['count'] ?? 0) + $tierRatingCount;
            $concept->update(['tier_ratings' => $tierRatings]);

            $concept = $progression->recordPracticeSet($concept, $avgRating);
            $concept = $progression->updateAutoStatus($concept);
            $nextUnlock = $progression->getNextUnlockThreshold($concept);
            $masteryTier = $progression->getMasteryTier($concept->mastery_score ?? 0);

            $submittedQuestion = GeneratedQuestion::find($qaPairs[0]['question_id']);
            $submittedSetNumber = $submittedQuestion ? $submittedQuestion->set_number : 1;

            $tierSets = $concept->generatedQuestions()
                ->where('tier', $tier)
                ->orderBy('set_number')
                ->pluck('set_number')
                ->unique()
                ->values()
                ->toArray();
            $pageIndex = array_search($submittedSetNumber, $tierSets);
            $page = $pageIndex !== false ? $pageIndex + 1 : 1;

            return redirect(route('concepts.practice', $concept) . '?tier=' . $tier . '&page=' . $page)->with([
                'success' => 'Answers evaluated successfully!',
                'xp_earned' => $totalXp,
                'bonus_xp' => $bonusXp,
                'new_xp' => $concept->xp,
                'avg_rating' => round($avgRating, 1),
                'mastery_score' => $concept->mastery_score,
                'mastery_tier' => $masteryTier['label'],
                'next_unlock' => $nextUnlock,
                'highest_tier' => $concept->getHighestUnlockedTier(),
                'streak' => $concept->practice_streak,
                'is_perfect' => $isPerfectSet,
                'first_today' => $isFirstToday,
                'rating_improved' => $ratingImproved ?? false,
                'milestone_xp' => $milestoneXp,
            ]);
        } catch (\RuntimeException $e) {
            return back()->with('error', 'Failed to evaluate answers: ' . $e->getMessage());
        }
    }

    public function archives(Domain $domain)
    {
        $this->authorize('view', $domain);

        $concepts = Concept::onlyTrashed()
            ->where('domain_id', $domain->id)
            ->whereHas('domain', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('concepts.archives', compact('concepts', 'domain'));
    }

    public function improveExplanation(Concept $concept, GroqService $groq)
    {
        $this->authorize('update', $concept);

        try {
            $suggestion = $groq->improveConceptExplanation($concept);

            return response()->json(['suggestion' => $suggestion]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => 'Failed to generate suggestion: ' . $e->getMessage()], 500);
        }
    }

    public function acceptExplanation(Request $request, Concept $concept, ProgressionService $progression)
    {
        $this->authorize('update', $concept);

        $data = $request->validate([
            'explanation' => 'required|string|max:5000',
        ]);

        $previouslyEmpty = empty(trim($concept->explanation ?? ''));

        $concept->update(['explanation' => $data['explanation']]);

        if ($previouslyEmpty) {
            $progression->awardExplanationXp($concept);
        }

        return redirect()->route('concepts.show', $concept)->with('success', 'Explanation updated successfully.');
    }

}