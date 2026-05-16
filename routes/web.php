<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $domains = Auth::user()->domains()
        ->withCount('concepts')
        ->withCount(['concepts as mastered_count' => function ($query) {
            $query->where('status', 'mastered');
        }])
        ->get();

    $totalConcepts = $domains->sum('concepts_count');
    $totalMastered = $domains->sum('mastered_count');
    $masteryRate = $totalConcepts > 0 ? round(($totalMastered / $totalConcepts) * 100) : 0;

    $topDomain = $domains->sortByDesc(fn($d) => $d->concepts_count > 0 ? $d->mastered_count / $d->concepts_count : 0)->first();

    $reviewConcepts = \App\Models\Concept::whereIn('domain_id', Auth::user()->domains()->pluck('id'))
        ->where('status', 'to_review')
        ->with('domain')
        ->latest('updated_at')
        ->take(3)
        ->get();

    return view('dashboard', compact('domains', 'totalConcepts', 'totalMastered', 'masteryRate', 'topDomain', 'reviewConcepts'));
})->middleware(['auth', 'verified', 'onboarding'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/onboarding/skip', [OnboardingController::class, 'skip'])->name('onboarding.skip');
});

Route::middleware(['auth', 'onboarding'])->group(function () {
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/create', [DomainController::class, 'create'])->name('domains.create');
    Route::post('/domains', [DomainController::class, 'store'])->name('domains.store');
    Route::get('/domains/archives', [DomainController::class, 'archives'])->name('domains.archives');
    Route::post('/domains/{domain}/restore', [DomainController::class, 'restore'])->name('domains.restore')->withTrashed('domain');
    Route::delete('/domains/{domain}/force', [DomainController::class, 'forceDelete'])->name('domains.forceDelete')->withTrashed('domain');
    Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    Route::get('/domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::post('/domains/{domain}/improve-description', [DomainController::class, 'improveDescription'])->name('domains.improveDescription')->middleware('throttle:ai-actions');
    Route::post('/domains/{domain}/accept-description', [DomainController::class, 'acceptDescription'])->name('domains.acceptDescription');

    Route::get('/domains/{domain}/concepts/create', [ConceptController::class, 'create'])->name('concepts.create');
    Route::post('/domains/{domain}/concepts/verify-title', [ConceptController::class, 'verifyTitle'])->name('concepts.verifyTitle')->middleware('throttle:ai-actions');
    Route::post('/domains/{domain}/concepts/generate-explanation', [ConceptController::class, 'generateExplanation'])->name('concepts.generateExplanation')->middleware('throttle:ai-actions');
    Route::post('/domains/{domain}/concepts', [ConceptController::class, 'store'])->name('concepts.store');
    Route::get('/concepts/{concept}', [ConceptController::class, 'show'])->name('concepts.show');
    Route::get('/concepts/{concept}/practice', [ConceptController::class, 'practice'])->name('concepts.practice');
    Route::get('/concepts/{concept}/edit', [ConceptController::class, 'edit'])->name('concepts.edit');
    Route::put('/concepts/{concept}', [ConceptController::class, 'update'])->name('concepts.update');
    Route::patch('/concepts/{concept}/status', [ConceptController::class, 'updateStatus'])->name('concepts.updateStatus');
    Route::post('/concepts/{concept}/generate-questions', [ConceptController::class, 'generateQuestions'])->name('concepts.generateQuestions')->middleware('throttle:ai-actions');
    Route::post('/concepts/{concept}/submit-answers', [ConceptController::class, 'submitAnswers'])->name('concepts.submitAnswers')->middleware('throttle:ai-actions');
    Route::delete('/concepts/{concept}', [ConceptController::class, 'archive'])->name('concepts.archive');
    Route::post('/concepts/{concept}/restore', [ConceptController::class, 'restore'])->name('concepts.restore')->withTrashed('concept');
    Route::delete('/concepts/{concept}/force', [ConceptController::class, 'forceDelete'])->name('concepts.forceDelete')->withTrashed('concept');
    Route::post('/concepts/{concept}/improve-explanation', [ConceptController::class, 'improveExplanation'])->name('concepts.improveExplanation')->middleware('throttle:ai-actions');
    Route::post('/concepts/{concept}/accept-explanation', [ConceptController::class, 'acceptExplanation'])->name('concepts.acceptExplanation');
    Route::get('/domains/{domain}/concepts/archives', [ConceptController::class, 'archives'])->name('concepts.archives');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
