<?php

namespace App\Enums;

enum BillingCycle: string
{
    case Monthly = 'Monthly';
    case Yearly = 'Yearly';
}