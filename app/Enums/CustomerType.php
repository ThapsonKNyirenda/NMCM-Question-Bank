<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CustomerType: string
{
    use EnumToArray;

    case Company = 'Company';
    case Individual = 'Individual';
}
