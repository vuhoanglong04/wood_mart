<?php

namespace App\Providers;

use App\Policies\OrdersPolicy;
use App\Policies\UserPolicy;
use App\Policies\GroupsPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductsPolicy;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Gate;
use App\Policies\ProductsVariantPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies =[
        GroupsPolicy::class,
        UserPolicy::class,
        CategoryPolicy::class,
        ProductsPolicy::class
    ];
    public function register(): void
    {
        Builder::useVite();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('groups.view' , [GroupsPolicy::class , 'view']);
        Gate::define('groups.add' , [GroupsPolicy::class , 'create']);
        Gate::define('groups.edit' , [GroupsPolicy::class , 'update']);
        Gate::define('groups.delete' , [GroupsPolicy::class , 'delete']);
        Gate::define('groups.forceDelete' , [GroupsPolicy::class , 'forceDelete']);
        Gate::define('groups.restore' , [GroupsPolicy::class , 'restore']);
        Gate::define('groups.authorization' , [GroupsPolicy::class , 'authorization']);


        Gate::define('user.view' , [UserPolicy::class , 'view']);
        Gate::define('user.add' , [UserPolicy::class , 'create']);
        Gate::define('user.edit' , [UserPolicy::class , 'update']);
        Gate::define('user.delete' , [UserPolicy::class , 'delete']);
        Gate::define('user.forceDelete' , [UserPolicy::class , 'forceDelete']);
        Gate::define('user.restore' , [UserPolicy::class , 'restore']);
        Gate::define('user.detail' , [UserPolicy::class , 'detail']);
        Gate::define('user.authorization' , [UserPolicy::class , 'authorization']);

         Gate::define('categories.view' , [CategoryPolicy::class , 'view']);
        Gate::define('categories.add' , [CategoryPolicy::class , 'create']);
        Gate::define('categories.edit' , [CategoryPolicy::class , 'update']);
        Gate::define('categories.delete' , [CategoryPolicy::class , 'delete']);
        Gate::define('categories.forceDelete' , [CategoryPolicy::class , 'forceDelete']);
        Gate::define('categories.restore' , [CategoryPolicy::class , 'restore']);

        Gate::define('products.view' , [ProductsPolicy::class , 'view']);
        Gate::define('products.add' , [ProductsPolicy::class , 'create']);
        Gate::define('products.edit' , [ProductsPolicy::class , 'update']);
        Gate::define('products.delete' , [ProductsPolicy::class , 'delete']);
        Gate::define('products.forceDelete' , [ProductsPolicy::class , 'forceDelete']);
        Gate::define('products.restore' , [ProductsPolicy::class , 'restore']);
        Gate::define('products.detail' , [ProductsPolicy::class , 'detail']);


        Gate::define('productsVariant.view' , [ProductsVariantPolicy::class , 'view']);
        Gate::define('productsVariant.add' , [ProductsVariantPolicy::class , 'create']);
        Gate::define('productsVariant.delete' , [ProductsVariantPolicy::class , 'delete']);
        Gate::define('productsVariant.forceDelete' , [ProductsVariantPolicy::class , 'forceDelete']);
        Gate::define('productsVariant.restore' , [ProductsVariantPolicy::class , 'restore']);


        Gate::define('orders.view' , [OrdersPolicy::class , 'view']);
        Gate::define('orders.detail' , [OrdersPolicy::class , 'detail']);
        Gate::define('orders.update' , [OrdersPolicy::class , 'update']);
    }
}
