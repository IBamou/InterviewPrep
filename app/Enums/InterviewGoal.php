<?php

namespace App\Enums;

enum InterviewGoal: string
{
    case FirstJob = 'first_job';
    case CareerSwitch = 'career_switch';
    case Promotion = 'promotion';
    case StaySharp = 'stay_sharp';
    case JobHunting = 'job_hunting';

    public function label(): string
    {
        return match ($this) {
            self::FirstJob => 'Land my first job',
            self::CareerSwitch => 'Career switch',
            self::Promotion => 'Get promoted',
            self::StaySharp => 'Stay sharp',
            self::JobHunting => 'Job hunting',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::FirstJob => 'Preparing for entry-level interviews',
            self::CareerSwitch => 'Transitioning into a new tech role',
            self::Promotion => 'Aiming for a senior or lead role',
            self::StaySharp => 'Keep my skills up to date',
            self::JobHunting => 'Actively interviewing right now',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FirstJob => 'emoji_events',
            self::CareerSwitch => 'swap_horiz',
            self::Promotion => 'trending_up',
            self::StaySharp => 'bolt',
            self::JobHunting => 'search',
        };
    }
}
