<?php

namespace App\Enums;

enum IncomeType: int
{
    case Martyrs = 1;
    case Retired = 2;
    case Aid     = 3;
    case Others  = 4;
}
