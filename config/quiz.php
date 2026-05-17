<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Quiz Requirements
    |--------------------------------------------------------------------------
    |
    | A concept must meet ALL of the following conditions to be eligible
    | for inclusion in a quiz.
    |
    */

    'requirements' => [
        'min_evaluated_sets' => env('QUIZ_MIN_EVALUATED_SETS', 1),
        'min_avg_rating' => env('QUIZ_MIN_AVG_RATING', 2.5),
        'requires_explanation' => env('QUIZ_REQUIRES_EXPLANATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Requirements
    |--------------------------------------------------------------------------
    |
    | A domain must have at least this many quiz-ready concepts before
    | a quiz can be started.
    |
    */

    'domain' => [
        'min_ready_concepts' => env('QUIZ_MIN_READY_CONCEPTS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Question Generation
    |--------------------------------------------------------------------------
    |
    | Controls how many questions are generated per quiz.
    |
    */

    'questions' => [
        'min_per_quiz' => env('QUIZ_MIN_QUESTIONS', 10),
        'max_per_quiz' => env('QUIZ_MAX_QUESTIONS', 15),
        'per_concept' => env('QUIZ_QUESTIONS_PER_CONCEPT', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Timer
    |--------------------------------------------------------------------------
    |
    | Minutes allocated per question.
    |
    */

    'timer' => [
        'minutes_per_question' => env('QUIZ_MINUTES_PER_QUESTION', 1.5),
        'min_minutes' => env('QUIZ_MIN_MINUTES', 10),
    ],

];
