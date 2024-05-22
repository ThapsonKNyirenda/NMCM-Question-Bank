<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\ActivityLog;

trait CausesActivity
{
    public function actions(): MorphMany
    {
        return $this->morphMany( ActivityLog::class, 'causer');
    }
}
