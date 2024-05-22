<?php

use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\CategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/products',ProductsController::class);
Route::get('products/restore/{products}', [ProductsController::class , 'restore']);
Route::delete('products/forceDelete/{products}', [ProductsController::class , 'forceDelete']);

Route::resource('/categories',CategoryController::class);
Route::get('categories/restore/{category}', [CategoryController::class , 'restore']);
Route::delete('categories/forceDelete/{category}', [CategoryController::class , 'forceDelete']);

Route::resource('/users',UserController::class);
Route::get('users/restore/{users}', [UserController::class , 'restore']);
Route::delete('users/forceDelete/{users}', [UserController::class , 'forceDelete']);

Route::resource('/groups',GroupsController::class);
Route::get('groups/restore/{group}', [GroupsController::class , 'restore']);
Route::delete('groups/forceDelete/{group}', [GroupsController::class , 'forceDelete']);

Route::resource('/orders',OrdersController::class);

