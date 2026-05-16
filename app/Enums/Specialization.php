<?php

namespace App\Enums;

enum Specialization: string
{
    case Backend = 'backend';
    case Frontend = 'frontend';
    case FullStack = 'fullstack';
    case DevOps = 'devops';
    case Data = 'data';
    case General = 'student';

    public function label(): string
    {
        return match ($this) {
            self::Backend => 'Backend',
            self::Frontend => 'Frontend',
            self::FullStack => 'Full Stack',
            self::DevOps => 'DevOps',
            self::Data => 'Data',
            self::General => 'General',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Backend => 'dns',
            self::Frontend => 'web',
            self::FullStack => 'layers',
            self::DevOps => 'settings_suggest',
            self::Data => 'bar_chart',
            self::General => 'school',
        };
    }
}
