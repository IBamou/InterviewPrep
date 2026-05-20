<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    private function withMasteredCount(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->withCount(['concepts as mastered_count' => function ($q) {
            $q->where('status', 'mastered');
        }]);
    }

    public function index()
    {
        $domains = $this->withMasteredCount(Domain::where('user_id', Auth::id()))
            ->withCount('concepts')
            ->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        $this->authorize('create', Domain::class);

        return view('domains.create');
    }

    public function store(StoreDomainRequest $request)
    {
        $this->authorize('create', Domain::class);

        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        Domain::create($validated);

        return redirect()->route('domains.index')->with('success', 'Domain created successfully.');
    }

    public function show(Domain $domain)
    {
        $this->authorize('view', $domain);

        $domain->loadCount(['concepts', 'concepts as mastered_count' => fn ($q) => $q->where('status', 'mastered')])->load('concepts');

        return view('domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $this->authorize('update', $domain);

        $domain->loadCount('concepts');

        return view('domains.edit', compact('domain'));
    }

    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $validated = $request->validated();

        $domain->update($validated);

        return redirect()->route('domains.index')->with('success', 'Domain updated successfully.');
    }

    public function destroy(Domain $domain)
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domain deleted successfully.');
    }

    public function archives()
    {
        $domains = Domain::onlyTrashed()
            ->where('user_id', Auth::id())
            ->paginate(20);

        return view('domains.archives', compact('domains'));
    }

    public function restore(Domain $domain)
    {
        $this->authorize('restore', $domain);

        $domain->restore();

        return redirect()->route('domains.archives')->with('success', 'Domain restored successfully.');
    }

    public function forceDelete(Domain $domain)
    {
        $this->authorize('forceDelete', $domain);

        $domain->forceDelete();

        return redirect()->route('domains.archives')->with('success', 'Domain permanently deleted.');
    }

    public function improveDescription(Domain $domain, AiService $ai)
    {
        $this->authorize('update', $domain);

        try {
            $suggestion = $ai->improveDomainDescription($domain);

            return response()->json(['suggestion' => $suggestion]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => 'Failed to generate suggestion: ' . $e->getMessage()], 500);
        }
    }

    public function acceptDescription(Request $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $data = $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $domain->update(['description' => $data['description']]);

        return redirect()->route('domains.show', $domain)->with('success', 'Description updated successfully.');
    }
}
