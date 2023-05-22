<?php

namespace App\Enums;

enum HousingType: int
{
    case Rent      = 1;
    case Ownership = 2;
    case Illegal   = 3;
    case Others    = 4;
}
