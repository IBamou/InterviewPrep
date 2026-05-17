<?php

use App\Http\Controllers\Api\GroqController;

Route::prefix('groq')->group(function () {

    // Basic chat
    Route::post('/chat', [GroqController::class, 'chat']);

    // Chat with history
    Route::post('/chat/history', [GroqController::class, 'chatHistory']);

    // Chat with persona/system prompt
    Route::post('/chat/persona', [GroqController::class, 'chatWithPersona']);

    // Streaming
    Route::post('/chat/stream', [GroqController::class, 'stream']);

    // List models
    Route::get('/models', [GroqController::class, 'models']);

})->middleware(['auth:sanctum', 'throttle:60,1']);
