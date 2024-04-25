<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
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
Route::prefix('admin')->middleware('login')->name('admin.')->group(function(){
        //Dashboard
        Route::get('/', [DashboardController::class , 'index'])->name('index');

        //Users
        Route::prefix('users')->name('users.')->group(function(){
                Route::get('/' , [UserController::class , 'index'])->name('index');
                Route::get('get-list' , [UserController::class , 'getList'])->name('list');
                Route::get('add' , [UserController::class , 'add'])->name('add');

        });

});

