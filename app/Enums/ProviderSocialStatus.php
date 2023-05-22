<?php

namespace App\Enums;

enum ProviderSocialStatus: int
{
    case Widow        = 1;
    case Divorced     = 2;
    case Married      = 3;
    case SpecialNeeds = 4;
    case Missing      = 5;
    case Hanging      = 6;
}
