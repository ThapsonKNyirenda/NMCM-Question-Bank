<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    private string $manageUsers = 'Manage users';

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can($this->manageUsers);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return Response|bool
     */
    public function view(User $user, User $model):Response|bool
    {
        return $user->can($this->manageUsers) || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->can($this->manageUsers);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $user, User $model): Response|bool
    {
        return $user->can($this->manageUsers) || $user->id === $model->id;
    }

    /**
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function assignRole(User $user, User $model): bool
    {
        return $user->can($this->manageUsers);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function restore(User $user, User $model): Response|bool
    {
        return $user->hasRole('Super User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function forceDelete(User $user, User $model): Response|bool
    {
        return $user->hasRole('Super User');
    }
}
