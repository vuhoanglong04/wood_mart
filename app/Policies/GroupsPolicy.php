<?php

namespace App\Policies;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
            return $user->hasPermission('groups' , 'view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('groups' , 'add');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('groups' , 'edit');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermission('groups' , 'delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasPermission('groups' , 'restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasPermission('groups' , 'forceDelete');

    }
    public function authorization(User $user)
    {
        return $user->hasPermission('groups' , 'authorization');
    }
}
