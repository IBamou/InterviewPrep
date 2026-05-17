<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $domains = $user->domains()
            ->withCount('concepts')
            ->withCount(['concepts as mastered_count' => function ($query) {
                $query->where('status', 'mastered');
            }])
            ->withCount(['concepts as in_progress_count' => function ($query) {
                $query->where('status', 'in_progress');
            }])
            ->withCount(['concepts as to_review_count' => function ($query) {
                $query->where('status', 'to_review');
            }])
            ->get();

        $totalConcepts = $domains->sum('concepts_count');
        $totalMastered = $domains->sum('mastered_count');
        $masteryRate = $totalConcepts > 0 ? round(($totalMastered / $totalConcepts) * 100) : 0;

        $topDomain = $domains->sortByDesc(fn ($d) => $d->concepts_count > 0 ? $d->mastered_count / $d->concepts_count : 0)->first();

        $domainIds = $domains->pluck('id');

        $reviewConcepts = Concept::whereIn('domain_id', $domainIds)
            ->where('status', 'to_review')
            ->with('domain')
            ->latest('updated_at')
            ->take(3)
            ->get();

        $staleConcepts = Concept::whereIn('domain_id', $domainIds)
            ->where('updated_at', '<', now()->subDays(30))
            ->with('domain')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $allUserConcepts = Concept::whereIn('domain_id', $domainIds)->get(['practice_streak', 'practice_sessions']);
        $longestStreak = 0;
        $todayPracticed = false;
        $today = now()->toDateString();
        foreach ($allUserConcepts as $c) {
            $streak = $c->practice_streak ?? [];
            $longestStreak = max($longestStreak, $streak['longest'] ?? 0);
            $sessions = $c->practice_sessions ?? [];
            foreach ($sessions as $s) {
                if (($s['date'] ?? null) === $today) {
                    $todayPracticed = true;
                    break;
                }
            }
        }

        return view('dashboard', compact('domains', 'totalConcepts', 'totalMastered', 'masteryRate', 'topDomain', 'reviewConcepts', 'staleConcepts', 'longestStreak', 'todayPracticed'));
    }
}
