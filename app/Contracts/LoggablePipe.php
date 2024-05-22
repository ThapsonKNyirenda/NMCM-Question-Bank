<?php

namespace App\Contracts;

use App\Services\EventLogBag;
use Closure;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
