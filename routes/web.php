<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/create', [DomainController::class, 'create'])->name('domains.create');
    Route::post('/domains', [DomainController::class, 'store'])->name('domains.store');
    Route::get('/domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    Route::get('/domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');

    Route::get('/domains/{domain}/concepts', [ConceptController::class, 'index'])->name('concepts.index');
    Route::get('/domains/{domain}/concepts/create', [ConceptController::class, 'create'])->name('concepts.create');
    Route::post('/domains/{domain}/concepts', [ConceptController::class, 'store'])->name('concepts.store');
    Route::get('/concepts/{concept}', [ConceptController::class, 'show'])->name('concepts.show');
    Route::get('/concepts/{concept}/edit', [ConceptController::class, 'edit'])->name('concepts.edit');
    Route::put('/concepts/{concept}', [ConceptController::class, 'update'])->name('concepts.update');
    Route::patch('/concepts/{concept}/status', [ConceptController::class, 'updateStatus'])->name('concepts.updateStatus');
    Route::delete('/concepts/{concept}', [ConceptController::class, 'archive'])->name('concepts.archive');
    Route::post('/concepts/{concept}/restore', [ConceptController::class, 'restore'])->name('concepts.restore');
    Route::delete('/concepts/{concept}/force', [ConceptController::class, 'forceDelete'])->name('concepts.forceDelete');
    Route::get('/domains/{domain}/concepts/archives', [ConceptController::class, 'archives'])->name('concepts.archives');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
