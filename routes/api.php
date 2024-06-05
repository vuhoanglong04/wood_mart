<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\TopicsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\UserAddressController;
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
//Auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Google
Route::get('/auth/google', [AuthController::class, 'loginGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'loginGoogleHandle']);

//Product
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
//Category
Route::get('/category', [CategoryController::class, 'index']);
//Topic
Route::get('/topics' , [TopicsController::class, 'index']);
//Posts
Route::get('/posts' , [PostsController::class, 'index']);
Route::get('/posts/{slug}' , [PostsController::class, 'show']);
//Reviews
Route::get('/reviews', [UserReviewsController::class, 'index']);


Route::middleware(['auth:sanctum'])->group(function () {
    //Addrress
    Route::get('/address', [UserAddressController::class, 'index']);
    Route::post('/address', [UserAddressController::class, 'store']);
    Route::patch('/address/{id}', [UserAddressController::class, 'update']);
    //Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::patch('/cart/{user_id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    //orders
    Route::get('/orders', [OrdersController::class, 'index']);
    Route::get('/orders/detail/{id}', [OrdersController::class, 'show']);
    Route::post('/orders', [OrdersController::class, 'store']);
    Route::patch('/orders/{id}', [OrdersController::class, 'update']);
    //user detail
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    //Review
    Route::post('/reviews', [UserReviewsController::class, 'store']);
    Route::patch('/reviews/{id}', [UserReviewsController::class, 'update']);
    //Wishlish
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    Route::get('momo', [PaymentOnlineController::class, 'momo'])->name('momo');
    Route::get('vnpay', [PaymentOnlineController::class, 'vnpay'])->name('vnpay');
});

