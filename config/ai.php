<?php

return [

    'default_provider' => env('AI_PROVIDER', 'openai'),

    'providers' => [
        'openai' => [
            'api_key' => env('AI_API_KEY'),
            'base_url' => env('AI_BASE_URL', 'https://api.groq.com/openai/v1'),
            'model' => env('AI_MODEL', 'llama-3.3-70b-versatile'),
        ],
        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'model' => env('ANTHROPIC_MODEL', 'claude-3-5-sonnet-20241022'),
        ],
    ],

    'defaults' => [
        'max_tokens' => (int) env('AI_MAX_TOKENS', 1024),
        'temperature' => (float) env('AI_TEMPERATURE', 0.7),
        'timeout' => (int) env('AI_TIMEOUT', 30),
    ],

    'tokens' => [
        'description' => (int) env('AI_DESCRIPTION_TOKENS', 300),
        'explanation' => (int) env('AI_EXPLANATION_TOKENS', 500),
        'evaluation' => (int) env('AI_EVALUATION_TOKENS', 2048),
        'generation' => (int) env('AI_GENERATION_TOKENS', 8192),
        'verification' => (int) env('AI_VERIFICATION_TOKENS', 100),
    ],

    'temperatures' => [
        'verification' => (float) env('AI_VERIFICATION_TEMPERATURE', 0.2),
    ],

];
