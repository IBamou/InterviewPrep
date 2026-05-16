<?php

namespace App\Enums;

enum UserStatus: string
{
    case Student = 'student';
    case Professional = 'professional';

    public function label(): string
    {
        return match ($this) {
            self::Student => 'Student',
            self::Professional => 'Professional',
        };
    }
}
