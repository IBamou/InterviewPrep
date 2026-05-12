<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Domain;
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

        $concept->load(['domain' => function ($query) {
            $query->withCount('concepts');
        }]);

        return view('concepts.show', compact('concept'));
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

    // US11 - Generate interview questions (placeholder)
    // TODO: Send a request to Groq API to generate 5 interview questions
    // based on the concept's title and explanation
    // Store the generated questions in the generated_questions table
    // Return them to the view
    public function generateQuestions(Concept $concept)
    {
        // Placeholder for Groq API integration
        // Will be implemented in a future branch
    }
}