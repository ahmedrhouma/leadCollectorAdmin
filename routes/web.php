<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountsController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::match(['get','post'],'/facebook/message',[\App\Http\Controllers\FacebookController::class,'receive'])->name('receive');
Route::get('/facebook/callback',[\App\Http\Controllers\FacebookController::class,'callback']);
Route::get('/dashboard',[\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');
Route::get('/users',[\App\Http\Controllers\DashboardController::class,'users'])->name('users');
Route::get('/channels',[\App\Http\Controllers\DashboardController::class,'channels'])->name('channels');
