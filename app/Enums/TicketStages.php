<?php

namespace App\Enums;

enum TicketStages: string
{
    case Open = 'Open';
    case Pending = 'Pending';
    case Resolved = 'Resolved';
    case Closed = 'Closed';
    case Reopened ='Reopened';
}
