<?php

namespace App\Enums;

enum UserRole: int
{
    case Superadmin = 1;
    case RW         = 2;
    case RO         = 3;
}
