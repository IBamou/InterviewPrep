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

    public function store(StoreConceptRequest $request, Domain $domain)
    {
        $this->authorize('view', $domain);

        $validated = $request->validated();
        $validated['domain_id'] = $domain->id;
        $validated['status'] = Status::ToReview;

        Concept::create($validated);

        return redirect()->route('domains.show', $domain)->with('success', 'Concept created successfully.');
    }

    public function show(Concept $concept)
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

        $tiers = ['junior', 'mid', 'senior'];
        $tierData = [];
        foreach ($tiers as $tier) {
            $tierData[$tier] = $questionSets->get($tier, collect());
        }

        return view('concepts.show', compact('concept', 'tierData', 'tiers'));
    }

    public function practice(Concept $concept, Request $request)
    {
        $this->authorize('view', $concept);

        $concept->load('domain');

        $tier = $request->query('tier', 'junior');
        $questionSets = $concept->generatedQuestions()
            ->where('tier', $tier)
            ->orderBy('set_number')
            ->orderBy('id')
            ->get()
            ->groupBy('set_number');

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

        $allTiers = ['junior', 'mid', 'senior'];
        $tierMetadata = [];
        foreach ($allTiers as $t) {
            $tierQuestions = $concept->generatedQuestions()->where('tier', $t)->get()->groupBy('set_number');
            $sets = [];
            foreach ($tierQuestions as $setNum => $questions) {
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

    public function update(UpdateConceptRequest $request, Concept $concept)
    {
        $this->authorize('update', $concept);

        $concept->update($request->validated());

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
            'answers.*.question_id' => 'required|exists:generated_questions,id',
            'answers.*.answer' => 'nullable|string|max:10000',
        ]);

        try {
            $qaPairs = [];
            foreach ($data['answers'] as $item) {
                $question = GeneratedQuestion::findOrFail($item['question_id']);
                $question->update(['answer' => $item['answer'] ?? '']);
                $qaPairs[] = [
                    'question_id' => $item['question_id'],
                    'question' => $question->question,
                    'answer' => $item['answer'] ?? '',
                ];
            }

            $evaluations = $groq->evaluateAnswers($concept, $qaPairs);

            $firstQuestion = GeneratedQuestion::find($qaPairs[0]['question_id']);
            $tier = $firstQuestion ? $firstQuestion->tier : 'junior';

            $totalXp = 0;
            $totalRating = 0;
            $ratedCount = 0;
            $tierRatingSum = 0;
            $tierRatingCount = 0;
            foreach ($evaluations as $eval) {
                $idx = $eval['question_index'] ?? null;
                if ($idx !== null && isset($qaPairs[$idx])) {
                    $gq = GeneratedQuestion::find($qaPairs[$idx]['question_id']);
                    if ($gq) {
                        $gq->update([
                            'rating' => $eval['rating'] ?? null,
                            'feedback' => $eval['feedback'] ?? null,
                            'model_answer' => $eval['model_answer'] ?? null,
                        ]);

                        if ($eval['rating'] !== null) {
                            $totalXp += $progression->calculateXpForRating($eval['rating']);
                            $totalRating += $eval['rating'];
                            $ratedCount++;
                            $tierRatingSum += $eval['rating'];
                            $tierRatingCount++;
                        }
                    }
                }
            }

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

            $tierRatings = $concept->tier_ratings ?? [
                'junior' => ['sum' => 0, 'count' => 0],
                'mid' => ['sum' => 0, 'count' => 0],
                'senior' => ['sum' => 0, 'count' => 0],
            ];
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
                'new_xp' => $concept->xp,
                'avg_rating' => round($avgRating, 1),
                'mastery_score' => $concept->mastery_score,
                'mastery_tier' => $masteryTier['label'],
                'next_unlock' => $nextUnlock,
                'highest_tier' => $concept->getHighestUnlockedTier(),
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

    public function acceptExplanation(Request $request, Concept $concept)
    {
        $this->authorize('update', $concept);

        $data = $request->validate([
            'explanation' => 'required|string|max:5000',
        ]);

        $concept->update(['explanation' => $data['explanation']]);

        return redirect()->route('concepts.show', $concept)->with('success', 'Explanation updated successfully.');
    }

}