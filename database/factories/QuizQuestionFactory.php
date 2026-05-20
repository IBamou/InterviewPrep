<?php

namespace Database\Factories;

use App\Models\Concept;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'concept_id' => Concept::factory(),
            'question' => fake()->sentence(8) . '?',
            'sort_order' => 0,
        ];
    }
}
