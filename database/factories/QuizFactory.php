<?php

namespace Database\Factories;

use App\Enums\QuizStatus;
use App\Models\Domain;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'domain_id' => Domain::factory(),
            'time_limit_minutes' => 15,
            'status' => QuizStatus::InProgress,
        ];
    }
}
