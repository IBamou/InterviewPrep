<?php

// config/groq.php

return [

    /*
    |--------------------------------------------------------------------------
    | Groq API Key
    |--------------------------------------------------------------------------
    |
    | Your secret API key from https://console.groq.com/keys
    |
    */
    'api_key' => env('GROQ_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | The model used for chat completions.
    | Options: llama-3.3-70b-versatile, llama-3.1-8b-instant, etc.
    |
    */
    'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The Groq API endpoint. Usually no need to change this.
    |
    */
    'base_url' => env('GROQ_BASE_URL', 'https://api.groq.com/openai/v1'),

    /*
    |--------------------------------------------------------------------------
    | Default Parameters
    |--------------------------------------------------------------------------
    |
    | Default settings for every chat request.
    | Override per-request if needed.
    |
    */
    'defaults' => [
        'max_tokens'  => (int) env('GROQ_MAX_TOKENS', 1024),
        'temperature' => (float) env('GROQ_TEMPERATURE', 0.7),
        'timeout'     => (int) env('GROQ_TIMEOUT', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Per-operation token limits
    |--------------------------------------------------------------------------
    */
    'tokens' => [
        'description' => 300,
        'explanation' => 500,
        'evaluation'  => (int) env('GROQ_MAX_TOKENS', 1024) * 2,
        'generation'  => (int) env('GROQ_GENERATION_TOKENS', (int) env('GROQ_MAX_TOKENS', 1024) * 8),
        'verification' => 100,
    ],

    'temperatures' => [
        'verification' => 0.2,
    ],

];
