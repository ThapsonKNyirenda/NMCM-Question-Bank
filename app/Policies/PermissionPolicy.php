<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    use HandlesAuthorization;

    protected string $assignPermission = 'Assign permissions';

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can($this->assignPermission) || $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Permission $permission
     * @return Response|bool
     */
    public function view(User $user, Permission $permission): Response|bool
    {
        return $user->can( $this->assignPermission );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->hasRole('Super User') || $user->can($this->assignPermission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Permission $permission
     * @return Response|bool
     */
    public function update(User $user, Permission $permission): Response|bool
    {
        return $user->hasRole('Super User') || $user->can($this->assignPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Permission $permission
     * @return Response|bool
     */
    public function delete(User $user, Permission $permission): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Permission $permission
     * @return Response|bool
     */
    public function restore(User $user, Permission $permission): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Permission $permission
     * @return Response|bool
     */
    public function forceDelete(User $user, Permission $permission): Response|bool
    {
        return $user->hasRole('Super User');
    }
}
