<?php

namespace App\Enums;

enum FamilyType: int
{
    case SpecialNeeds = 1;
    case Orphans      = 2;
    case Chase        = 3;
    case Missing      = 4;
    case NoProvider   = 5;
    case Others       = 6;
}
