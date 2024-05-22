<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Role
{

    /**
     * A role may be given various permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * A permission can be assigned to user
     *
     * @return MorphToMany
     */
    public function users():MorphToMany;
}
