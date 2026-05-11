<?php

namespace App\Enums;

enum Status: string
{
    case ToReview = 'to_review';
    case InProgress = 'in_progress';
    case Mastered = 'mastered';

    public function label(): string
    {
        return match($this) {
            self::ToReview => 'To Review',
            self::InProgress => 'In Progress',
            self::Mastered => 'Mastered',
        };
    }

    public function next(): Status
    {
        return match($this) {
            self::ToReview => self::InProgress,
            self::InProgress => self::Mastered,
            self::Mastered => self::ToReview,
        };
    }
}