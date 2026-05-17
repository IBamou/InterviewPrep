<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\GeneratedQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q', '');
        $type = $request->query('type', 'all');

        $userDomains = Auth::user()->domains();
        $domainIds = $userDomains->clone()->pluck('id');

        $domains = collect();
        $concepts = collect();
        $questions = collect();

        if (empty($query)) {
            return view('search.index', [
                'query' => '',
                'type' => $type,
                'domains' => $domains,
                'concepts' => $concepts,
                'questions' => $questions,
                'totalResults' => 0,
                'domainCount' => 0,
                'conceptCount' => 0,
                'questionCount' => 0,
            ]);
        }

        $domainCount = $userDomains->clone()
            ->where('name', 'like', "%{$query}%")
            ->count();

        $conceptCount = Concept::where('title', 'like', "%{$query}%")
            ->whereIn('domain_id', $domainIds)->count();

        $questionCount = GeneratedQuestion::where('question', 'like', "%{$query}%")
            ->whereIn('concept_id', Concept::whereIn('domain_id', $domainIds)->pluck('id'))->count();

        if ($type === 'all' || $type === 'domains') {
            $domains = $userDomains->clone()
                ->where('name', 'like', "%{$query}%")
                ->withCount(['concepts', 'concepts as mastered_count' => function ($q) {
                    $q->where('status', 'mastered');
                }])
                ->paginate(20)
                ->withQueryString();
        }

        if ($type === 'all' || $type === 'concepts') {
            $concepts = Concept::where('title', 'like', "%{$query}%")
                ->whereIn('domain_id', $domainIds)
                ->with('domain')
                ->paginate(20)
                ->withQueryString();
        }

        if ($type === 'all' || $type === 'questions') {
            $questions = GeneratedQuestion::where('question', 'like', "%{$query}%")
                ->whereIn('concept_id', Concept::whereIn('domain_id', $domainIds)->pluck('id'))
                ->with(['concept.domain'])
                ->paginate(20)
                ->withQueryString();
        }

        $totalResults = $domainCount + $conceptCount + $questionCount;

        return view('search.index', compact('query', 'type', 'domains', 'concepts', 'questions', 'totalResults', 'domainCount', 'conceptCount', 'questionCount'));
    }
}
