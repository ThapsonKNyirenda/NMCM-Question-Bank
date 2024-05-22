<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPhoto
{
    public function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset($this->photo ?? '/images/profile-male.png')
        );
    }
}
