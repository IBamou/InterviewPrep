<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNoActiveQuiz
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $activeQuiz = $request->user()->quizzes()
                ->where('passed', false)
                ->where('status', 'in_progress')
                ->first();

            if ($activeQuiz && !$request->routeIs('quizzes.active', 'quizzes.submit', 'quizzes.results')) {
                return redirect()->route('quizzes.active', [
                    'domain' => $activeQuiz->domain_id,
                    'quiz' => $activeQuiz->id,
                ])->with('warning', 'You must finish your active quiz before accessing other pages.');
            }
        }

        return $next($request);
    }
}
