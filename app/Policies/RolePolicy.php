<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    protected string $manageRoles = 'Manage roles';

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can($this->manageRoles);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function view(User $user, Role $role): Response|bool
    {
        return $user->can($this->manageRoles);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->can($this->manageRoles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function update(User $user, Role $role): Response|bool
    {
        return $user->can($this->manageRoles);
    }

    public function assignRoles(User $user): bool
    {
        return $user->can('Assign roles');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function delete(User $user, Role $role): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function restore(User $user, Role $role): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $role
     * @return Response|bool
     */
    public function forceDelete(User $user, Role $role): Response|bool
    {
        return $user->hasRole('Super User');
    }
}
