<?php

namespace App\Enums;

enum UserRole: int
{
    case Superadmin = 1;
    case RW         = 2;
    case RO         = 3;

    public function canRead(): bool
    {
        return true;
    }

    public function canWrite(): bool
    {
        return in_array($this, [self::Superadmin, self::RW]);
    }

    public function isSuperadmin(): bool
    {
        return $this == self::Superadmin;
    }
}
