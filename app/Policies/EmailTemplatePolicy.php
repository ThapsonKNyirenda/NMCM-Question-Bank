<?php

namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmailTemplatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny(['Add email templates', 'Edit email templates', 'View email templates', 'Delete email templates']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmailTemplate $emailTemplate): bool
    {
        return $user->can('View email templates');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Add email templates');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmailTemplate $emailTemplate): bool
    {
        return $user->canAny(['Update email templates', 'Edit email templates']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmailTemplate $emailTemplate): Response|bool
    {
        return $emailTemplate->is_system_template
            ? Response::deny('Template cannot be deleted')
            : $user->can('Delete email templates');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmailTemplate $emailTemplate): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmailTemplate $emailTemplate): bool
    {
        //
    }
}
