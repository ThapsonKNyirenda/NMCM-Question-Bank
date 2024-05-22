<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public static function booted(): void
    {
        static::creating( function( Model $model ){
            $model->setAttribute('uuid', Str::orderedUuid());
        });
    }
}
