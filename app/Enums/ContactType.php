<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ContactType: string
{
    use EnumToArray;

    case Billing = 'Billing';
    case Technical = 'Technical';
    case Administrative = 'Administrative';
    case Others = 'Others';
}
