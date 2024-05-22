<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum TicketPriority: string
{
    use EnumToArray;

    case Low = 'Low';
    case Normal = 'Medium';
    case High = 'High';
    case Emergency = 'Urgent';
}
