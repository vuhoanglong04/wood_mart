<?php

namespace App\Policies;

use App\Models\User;
use App\Models\orders;
use Illuminate\Auth\Access\Response;

class OrdersPolicy
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
        return $user->hasPermission('orders' , 'view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('orders' , 'update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, orders $orders): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, orders $orders): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, orders $orders): bool
    {
        //
    }

    public function detail(User $user): bool
    {
        return $user->hasPermission('orders' , 'detail');

    }
}
