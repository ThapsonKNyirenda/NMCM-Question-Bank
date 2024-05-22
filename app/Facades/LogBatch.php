<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

use App\Services\LogBatch as ActivityLogBatch;

class LogBatch extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogBatch::class;
    }
}
