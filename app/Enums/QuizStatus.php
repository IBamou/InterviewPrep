<?php

namespace App\Enums;

enum QuizStatus: string
{
    case InProgress = 'in_progress';
    case Submitted = 'submitted';

    public function label(): string
    {
        return match($this) {
            self::InProgress => 'In Progress',
            self::Submitted => 'Submitted',
        };
    }
}
