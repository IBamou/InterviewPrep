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

        if (empty($query)) {
            return view('search.index', [
                'query' => '',
                'type' => $type,
                'domains' => collect(),
                'concepts' => collect(),
                'questions' => collect(),
                'totalResults' => 0,
            ]);
        }

        $userDomains = Auth::user()->domains();
        $domainIds = $userDomains->clone()->pluck('id');

        $domains = collect();
        $concepts = collect();
        $questions = collect();

        if ($type === 'all' || $type === 'domains') {
            $domains = $userDomains->clone()
                ->where('name', 'like', "%{$query}%")
                ->withCount(['concepts', 'concepts as mastered_count' => function ($q) {
                    $q->where('status', 'mastered');
                }])
                ->limit(20)
                ->get();
        }

        if ($type === 'all' || $type === 'concepts') {
            $concepts = Concept::where('title', 'like', "%{$query}%")
                ->orWhere('explanation', 'like', "%{$query}%")
                ->whereIn('domain_id', $domainIds)
                ->with('domain')
                ->limit(20)
                ->get();
        }

        if ($type === 'all' || $type === 'questions') {
            $questions = GeneratedQuestion::where('question', 'like', "%{$query}%")
                ->orWhere('answer', 'like', "%{$query}%")
                ->orWhere('feedback', 'like', "%{$query}%")
                ->orWhere('model_answer', 'like', "%{$query}%")
                ->whereIn('concept_id', Concept::whereIn('domain_id', $domainIds)->pluck('id'))
                ->with(['concept.domain'])
                ->limit(20)
                ->get();
        }

        $totalResults = $domains->count() + $concepts->count() + $questions->count();

        return view('search.index', compact('query', 'type', 'domains', 'concepts', 'questions', 'totalResults'));
    }
}
