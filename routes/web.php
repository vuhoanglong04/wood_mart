<?php

use App\Http\Controllers\NotificationsController;
use App\Models\User;
use App\Models\Posts;
use App\Models\Orders;
use App\Models\Category;
use App\Models\Products;
use App\Models\UserReviews;
use App\Models\ProductsVariant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\UserReviewsController;
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
Route::get('', function (){
    return redirect()->route('login');
});


//google
Route::get('auth/google' , [GoogleController::class ,'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback' , [GoogleController::class ,'handleGoogle'])->name('auth.google.callback');

//login-logout
Route::get('login', [AuthController::class , 'index'])->name('login')->middleware('logout');
Route::post('login', [AuthController::class , 'login']);
Route::get('logout', [AuthController::class , 'logout'])->name('logout')->middleware('login');
//forgot password
Route::get('forgot-password', [AuthController::class , 'forgotPassword'])->name('forgot-password')->middleware('logout');
Route::post('forgot-password', [AuthController::class , 'sendForgotPassword']);
//code verification
Route::get('code-verification', [AuthController::class , 'codeVerification'])->name('code-verification')->middleware('reset-password');
Route::post('code-verification', [AuthController::class , 'codeVerificationCheck']);
Route::get('reset-password', [AuthController::class , 'updatePasswordForm'])->name('reset-password')->middleware('reset-password');;
Route::post('reset-password', [AuthController::class , 'updateNewPassword']);

Route::get('/', [AuthController::class , 'login']);

Route::prefix('admin')->middleware(['login' ,'cacheResponse:600'])->name('admin.')->group(function(){
        //Dashboard
        Route::get('orders/export', [OrdersController::class, 'exportExcel'])->name('orders.export');
        Route::get('products/export', [ProductsController::class, 'exportExcel'])->name('products.export');

        Route::get('/', [DashboardController::class , 'index'])->name('index');
        //Modules
        Route::resource('modules' , ModulesController::class);
        //Groups
        Route::resource('groups' , GroupsController::class , ['parameters' => [
            'id' => 'id'
        ]]);
        Route::delete('groups/softDelete/{group}', [GroupsController::class , 'softDelete'])->name('groups.softDelete');
        Route::get('groups/restore/{group}', [GroupsController::class , 'restore'])->name('groups.restore');
        Route::get('groups/authorization/{group}', [GroupsController::class , 'authorizationForm'])->name('groups.authorization');
        Route::post('groups/authorization/{group}', [GroupsController::class , 'authorizationUpdate'])->name('groups.authorizationUpdate');

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
                Route::get('export', [UserController::class, 'exportExcel'])->name('export');

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
        //Orders
        Route::resource('orders' , OrdersController::class);
        Route::post('orders/update/{order}', [OrdersController::class , 'update'])->name('orders.update');
        Route::get('orders/exportPDF/{id}' ,[OrdersController::class , 'generatePDF'] )->name('orders.exportPDF');
        //Orders Detail
        Route::resource('order-detail' , OrderDetailController::class);

        //Vouchers
        Route::resource('vouchers' , VouchersController::class);

        //Topics
        Route::resource('topics' , TopicsController::class);
        Route::delete('topics/softDelete/{topic}', [TopicsController::class , 'softDelete'])->name('topics.softDelete');
        Route::get('topics/restore/{topic}', [TopicsController::class , 'restore'])->name('topics.restore');


        //Posts
        Route::resource('posts' , PostsController::class);
        Route::delete('posts/softDelete/{topic}', [PostsController::class , 'softDelete'])->name('posts.softDelete');
        Route::get('posts/restore/{topic}', [PostsController::class , 'restore'])->name('posts.restore');

        //Review
        Route::resource('/reviews' , UserReviewsController::class);
        Route::delete('reviews/softDelete/{review}', [UserReviewsController::class , 'softDelete'])->name('reviews.softDelete');
        Route::get('reviews/restore/{review}', [UserReviewsController::class , 'restore'])->name('reviews.restore');
    
        //Nofications
        Route::get('/notifications' , [NotificationsController::class , 'index']);
        Route::post('/notifications' , [NotificationsController::class , 'store']);

        //Others
        Route::get('/gallery' , function (){
            $imageProducts = Products::all();
            $imageUser = User::all();
            $imageCategory = Category::all();
            $imagePosts = Posts::all();
            $imageVariant = ProductsVariant::all();
            return view('gallery' , compact('imageProducts' , 'imageUser', 'imageCategory' , 'imagePosts' , 'imageVariant'));
        })->name('gallery');


        Route::get('/statistic' , function (){
            $orders = Orders::all()->count();
            $users = User::all()->count();
            $products = Products::all()->count();
            $sales = Orders::where('status', 5)->sum('total');
            $totalByUser =Orders::select('user_id', DB::raw('SUM(total) as total'))
            ->where('status', 5)
            ->groupBy('user_id')->with('user')
            ->get();
            $reviews  = UserReviews::all();
            return view('statistic',
            compact('orders' , 'users' , 'products' , 'sales' , 'totalByUser' , 'reviews'));
        })->name('statistic');

});

