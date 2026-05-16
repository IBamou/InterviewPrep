<?php

namespace App\Http\Requests;

use App\Enums\ExperienceLevel;
use App\Enums\InterviewGoal;
use App\Enums\Specialization;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'status' => ['nullable', Rule::enum(UserStatus::class)],
            'specialization' => ['nullable', Rule::enum(Specialization::class)],
            'experience_years' => ['nullable', Rule::enum(ExperienceLevel::class)],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['string', 'max:255'],
            'interview_goal' => ['nullable', Rule::enum(InterviewGoal::class)],
            'onboarding_completed' => ['nullable', 'boolean'],
        ];
    }
}
