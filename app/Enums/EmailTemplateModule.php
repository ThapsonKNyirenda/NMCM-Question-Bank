<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum EmailTemplateModule: string
{
    use EnumToArray;

    case HelpDesk = 'Help Desk';
    case Customer = 'Customer';
    case Ticket = 'Ticket';
}
