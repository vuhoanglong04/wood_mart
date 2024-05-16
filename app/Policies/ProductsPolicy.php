<?php

namespace App\Policies;

use App\Models\User;
use App\Models\products;
use Illuminate\Auth\Access\Response;

class ProductsPolicy
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
        return $user->hasPermission('products' , 'view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('products' , 'add');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('products' , 'edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermission('products' , 'delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasPermission('products' , 'restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user ): bool
    {
        return $user->hasPermission('products' , 'forceDelete');

    }
    public function detail(User $user ): bool
    {
        return $user->hasPermission('products' , 'detail');

    }
}
