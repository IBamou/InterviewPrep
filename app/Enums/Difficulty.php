<?php

namespace App\Enums;

enum Difficulty: string
{
    case Junior = 'junior';
    case Mid = 'mid';
    case Senior = 'senior';

    public function label(): string
    {
        return match($this) {
            self::Junior => 'Junior',
            self::Mid => 'Mid',
            self::Senior => 'Senior',
        };
    }
}
