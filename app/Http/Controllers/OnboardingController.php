<?php

namespace App\Http\Controllers;

use App\Enums\ExperienceLevel;
use App\Enums\InterviewGoal;
use App\Enums\Specialization;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OnboardingController extends Controller
{
    public function index()
    {
        if (Auth::user()->onboarding_completed) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.index', [
            'statusOptions' => collect(UserStatus::cases())->map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'icon' => $case === UserStatus::Student ? 'school' : 'work',
                'desc' => $case === UserStatus::Student ? 'Currently studying or recently graduated' : 'Working in tech or transitioning careers',
            ])->values()->all(),
            'specializationOptions' => collect(Specialization::cases())->map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'icon' => $case->icon(),
            ])->values()->all(),
            'experienceOptions' => collect(ExperienceLevel::cases())->map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ])->values()->all(),
            'goalOptions' => collect(InterviewGoal::cases())->map(fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'desc' => $case->description(),
                'icon' => $case->icon(),
            ])->values()->all(),
            'techOptions' => ['PHP', 'Laravel', 'JavaScript', 'TypeScript', 'Python', 'Java', 'React', 'Vue', 'Node.js', 'MySQL', 'PostgreSQL', 'MongoDB', 'Docker', 'AWS', 'Git', 'REST APIs'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => ['required', Rule::enum(UserStatus::class)],
            'specialization' => ['required', Rule::enum(Specialization::class)],
            'experience_years' => ['required', Rule::enum(ExperienceLevel::class)],
            'tech_stack' => 'required|array|min:1',
            'tech_stack.*' => 'string',
            'interview_goal' => ['required', Rule::enum(InterviewGoal::class)],
        ]);

        Auth::user()->update([
            'status' => $data['status'],
            'specialization' => $data['specialization'],
            'experience_years' => $data['experience_years'],
            'tech_stack' => $data['tech_stack'],
            'interview_goal' => $data['interview_goal'],
            'onboarding_completed' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profile set up successfully!');
    }

    public function skip()
    {
        Auth::user()->update(['onboarding_completed' => true]);

        return redirect()->route('dashboard');
    }
}
