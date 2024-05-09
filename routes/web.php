<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsVariant;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductsVariantController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class , 'index'])->name('login')->middleware('logout');
Route::post('login', [AuthController::class , 'login']);
Route::get('logout', [AuthController::class , 'logout'])->name('logout')->middleware('login');
Route::get('', [AuthController::class , 'login']);

Route::prefix('admin')->middleware('login')->name('admin.')->group(function(){
        //Dashboard
        Route::get('/', [DashboardController::class , 'index'])->name('index');
        //Groups
        Route::resource('groups' , GroupsController::class , ['parameters' => [
            'id' => 'id'
        ]]);
        Route::delete('groups/softDelete/{group}', [GroupsController::class , 'softDelete'])->name('groups.softDelete');
        Route::get('groups/restore/{group}', [GroupsController::class , 'restore'])->name('groups.restore');
        //Users
        Route::prefix('users')->name('users.')->group(function(){
                Route::get('/' , [UserController::class , 'index'])->name('index');
                Route::get('get-list' , [UserController::class , 'getList'])->name('list');
                Route::get('add' , [UserController::class , 'add'])->name('add');
                Route::post('add' , [UserController::class , 'postUser']);
                Route::get('delete/{id}' , [UserController::class , 'delete'])->name('delete');
                Route::get('force-delete/{id}' , [UserController::class , 'forceDelete'])->name('force-delete');
                Route::get('restore/{id}' , [UserController::class , 'restore'])->name('restore');
                Route::get('detail/{id}' , [UserController::class , 'detail'])->name('detail');
                Route::get('edit/{id}' , [UserController::class , 'edit'])->name('edit');
                Route::post('edit/{id}' , [UserController::class , 'update'])->name('update');
                Route::post('update-password/{id}' , [UserController::class , 'updatePassword'])->name('update-password');
        });


        //Category
        Route::resource('category' , CategoryController::class);
        Route::delete('category/softDelete/{category}', [CategoryController::class , 'softDelete'])->name('category.softDelete');
        Route::get('category/restore/{category}', [CategoryController::class , 'restore'])->name('category.restore');


        //Products
        Route::resource('products' , ProductsController::class);
        Route::delete('products/softDelete/{product}', [ProductsController::class , 'softDelete'])->name('products.softDelete');
        Route::get('products/restore/{product}', [ProductsController::class , 'restore'])->name('products.restore');
        //Products Variation
        Route::resource('productsVariation' , ProductsVariantController::class);
        Route::delete('productsVariation/softDelete/{productsVariation}', [ProductsVariantController::class , 'softDelete'])->name('productsVariation.softDelete');
        Route::get('productsVariation/restore/{productsVariation}', [ProductsVariantController::class , 'restore'])->name('productsVariation.restore');
    

});

