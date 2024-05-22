<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilterByStatus
{
    /**
     * Scope the query to include only customers that have the specified status if provided
     */
    public function scopeFilterByStatus( Builder $query,  ?string $isActive ): void
    {
        $query->when(
            $isActive,
            fn(Builder $qry) => $qry->where('is_active',  $isActive === 'true'),
            fn(Builder $qry) => $qry->where('is_active',  true),
        );
    }
}
