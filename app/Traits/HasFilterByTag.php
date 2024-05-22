<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilterByTag
{
    /**
     * Scope the query to include only customers who have the specified tags if provided
     */
    public function scopeFilterByTags( Builder $query,  ?array $tags ): void
    {
        $query->when( (!empty( $tags )), function (Builder $qry) use ($tags){
            $qry->whereHas('tags', function (Builder $q) use ($tags) {
                $q->whereIn('name', $tags );
            });
        });

    }
}
