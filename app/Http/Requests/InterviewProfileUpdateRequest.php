<?php

namespace App\Http\Requests;

use App\Enums\ExperienceLevel;
use App\Enums\InterviewGoal;
use App\Enums\Specialization;
use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InterviewProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::enum(UserStatus::class)],
            'specialization' => ['nullable', Rule::enum(Specialization::class)],
            'experience_years' => ['nullable', Rule::enum(ExperienceLevel::class)],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['string', 'max:255'],
            'interview_goal' => ['nullable', Rule::enum(InterviewGoal::class)],
        ];
    }
}
