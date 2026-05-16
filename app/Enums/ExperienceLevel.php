<?php

namespace App\Enums;

enum ExperienceLevel: string
{
    case None = '0';
    case LessThanOne = '0-1';
    case OneToThree = '1-3';
    case ThreeToFive = '3-5';
    case FivePlus = '5-10';
    case TenPlus = '10+';

    public function label(): string
    {
        return match ($this) {
            self::None => 'No experience',
            self::LessThanOne => 'Less than 1 year',
            self::OneToThree => '1–3 years',
            self::ThreeToFive => '3–5 years',
            self::FivePlus => '+5 years',
            self::TenPlus => '10+ years',
        };
    }
}
