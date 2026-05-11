<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::where('user_id', Auth::id())
            ->withCount('concepts')
            ->withCount(['concepts' => function ($query) {
                $query->where('status', 'mastered');
            }])
            ->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(StoreDomainRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        Domain::create($validated);

        return redirect()->route('domains.index')->with('success', 'Domain created successfully.');
    }

    public function show(Domain $domain)
    {
        $this->authorize('view', $domain);

        return view('domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $this->authorize('update', $domain);

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
}
