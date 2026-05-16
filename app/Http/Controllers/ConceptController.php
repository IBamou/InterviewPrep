<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Domain;
use App\Models\GeneratedQuestion;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConceptController extends Controller
{
    public function create(Domain $domain)
    {
        $this->authorize('view', $domain);

        return view('concepts.create', compact('domain'));
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
            ->groupBy('set_number')
            ->sortKeys();

        return view('concepts.show', compact('concept', 'questionSets'));
    }

    public function practice(Concept $concept, Request $request)
    {
        $this->authorize('view', $concept);

        $concept->load('domain');

        $questionSets = $concept->generatedQuestions()
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

        return view('concepts.practice', compact('concept', 'questionSets', 'currentSet', 'currentSetNumber', 'paginator', 'totalPages', 'setNumbers'));
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

    public function updateStatus(Concept $concept)
    {
        $this->authorize('update', $concept);

        $concept->status = $concept->status->next();
        $concept->save();

        return back()->with('success', 'Status updated to ' . $concept->status->label());
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
            $questions = $groq->generateQuestions($concept);

            if (isset($questions['error']) && $questions['error'] === 'unrelated') {
                return back()->with('error', $questions['message'] ?? 'The concept is not relevant to this domain.');
            }

            $maxSet = $concept->generatedQuestions()->max('set_number') ?? 0;
            $setNumber = $maxSet + 1;

            foreach ($questions as $question) {
                GeneratedQuestion::create([
                    'concept_id' => $concept->id,
                    'question' => $question,
                    'set_number' => $setNumber,
                ]);
            }

            return redirect(route('concepts.practice', $concept) . '?page=' . $setNumber)
                ->with('success', "Set {$setNumber}: 5 interview questions generated successfully.");
        } catch (\RuntimeException $e) {
            return back()->with('error', 'Failed to generate questions: ' . $e->getMessage());
        }
    }

    public function submitAnswers(Request $request, Concept $concept, GroqService $groq)
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
                    }
                }
            }

            return redirect()->route('concepts.practice', $concept)->with('success', 'Answers evaluated successfully!');
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