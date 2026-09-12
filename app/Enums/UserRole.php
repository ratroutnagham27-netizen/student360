<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN   = 'admin';
    case TEACHER = 'teacher';
    case PARENT  = 'parent';

    // Reserved for future V2 (not used in V1)
    // case STUDENT   = 'student';
    // case COUNSELOR = 'counselor';

    /**
     * Human-readable label for the role.
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN   => 'Administrator',
            self::TEACHER => 'Teacher',
            self::PARENT  => 'Parent',
        };
    }
}