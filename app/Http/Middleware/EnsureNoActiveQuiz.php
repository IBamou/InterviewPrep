<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNoActiveQuiz
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $activeQuiz = $request->user()->quizzes()
                ->where('status', 'in_progress')
                ->first();

            if ($activeQuiz && !$request->routeIs('quizzes.active', 'quizzes.update', 'quizzes.results')) {
                $domain = Domain::withTrashed()->find($activeQuiz->domain_id);

                if (!$domain) {
                    return $next($request);
                }

                return redirect()->route('quizzes.active', [
                    'domain' => $domain,
                    'quiz' => $activeQuiz,
                ])->with('warning', 'You must finish your active quiz before accessing other pages.');
            }
        }

        return $next($request);
    }
}
