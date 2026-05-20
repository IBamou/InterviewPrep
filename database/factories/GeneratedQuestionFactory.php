<?php

namespace Database\Factories;

use App\Models\Concept;
use App\Models\GeneratedQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneratedQuestionFactory extends Factory
{
    protected $model = GeneratedQuestion::class;

    public function definition(): array
    {
        return [
            'concept_id' => Concept::factory(),
            'question' => fake()->sentence(8) . '?',
            'set_number' => 1,
            'tier' => 'junior',
        ];
    }
}
