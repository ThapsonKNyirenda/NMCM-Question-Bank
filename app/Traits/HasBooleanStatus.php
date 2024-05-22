<?php

namespace App\Traits;

trait HasBooleanStatus
{
    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeWhereStatus($query, $status){
        $check = $status === "1" || $status === "0";

        return $query->when($check, function ($qry) use($status){
            return $qry->where('status', $status);
        });
    }
}
