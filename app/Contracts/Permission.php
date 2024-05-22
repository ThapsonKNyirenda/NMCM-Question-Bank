<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Permission
{
    /**
     * A permission can be applied to roles.
     *
     * @return BelongsToMany
     */
    public function roles():BelongsToMany;


    /**
     * A permission can be assigned to user
     *
     * @return MorphToMany
     */
    public function users():MorphToMany;
}
