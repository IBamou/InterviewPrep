<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConceptFactory extends Factory
{
    protected $model = Concept::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'title' => fake()->unique()->word(),
            'explanation' => fake()->paragraph(),
            'status' => Status::ToReview,
        ];
    }
}
