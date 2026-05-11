<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::where('user_id', Auth::id())
            ->withCount('concepts')
            ->withCount(['concepts' => function ($query) {
                $query->where('status', 'maîtrisé');
            }])
            ->get();

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);

        $validated['user_id'] = Auth::id();

        Domain::create($validated);

        return redirect()->route('domains.index')->with('success', 'Domaine créé avec succès.');
    }

    public function show(Domain $domain)
    {
        $this->authorizeDomain($domain);

        return view('domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $this->authorizeDomain($domain);

        return view('domains.edit', compact('domain'));
    }

    public function update(Request $request, Domain $domain)
    {
        $this->authorizeDomain($domain);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);

        $domain->update($validated);

        return redirect()->route('domains.index')->with('success', 'Domaine mis à jour.');
    }

    public function destroy(Domain $domain)
    {
        $this->authorizeDomain($domain);

        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domaine supprimé.');
    }

    private function authorizeDomain(Domain $domain): void
    {
        if ($domain->user_id !== Auth::id()) {
            abort(403);
        }
    }
}