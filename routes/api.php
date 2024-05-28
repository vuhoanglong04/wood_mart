<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\UserReviewsController;
use App\Http\Controllers\API\PaymentOnlineController;

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
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrdersController::class, 'store']);
    Route::get('/orders/detail/{id}', [OrdersController::class, 'show']);
    Route::patch('/orders/{id}', [OrdersController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::post('/review', [UserReviewsController::class, 'store']);
    Route::patch('/review/{id}', [UserReviewsController::class, 'update']);

    Route::post('vnpay', [PaymentOnlineController::class, 'vnpay'])->name('vnpay');
    Route::post('momo', [PaymentOnlineController::class, 'momo'])->name('momo');
});

