<?php

namespace App\Policies;

use App\Models\User;

class DescriptionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //Manage Question Scenarios
    }

    public function viewAny(User $user): bool
    {
        //
        return $user->can('Manage Question Scenarios');
    }
}