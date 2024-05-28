<?php

namespace App\Policies;

use App\Models\User;
use App\Models\vouchers;
use Illuminate\Auth\Access\Response;

class VouchersPolicy
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
        return $user->hasPermission('vouchers' , 'view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('vouchers' , 'add');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('vouchers' , 'edit');

    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermission('vouchers' , 'forceDelete');

    }
}
