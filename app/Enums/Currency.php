<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum Currency: string
{
    use EnumToArray;

    case MalawiKwacha = 'MWK';
    case USDollar = 'USD';
}
