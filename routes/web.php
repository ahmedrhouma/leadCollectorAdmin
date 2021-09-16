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
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[\App\Http\Controllers\Web\DashboardController::class,'index'])->name('dashboard');
    Route::get('/configuration',[\App\Http\Controllers\Web\DashboardController::class,'configuration'])->name('configuration');
    Route::get('/users',[\App\Http\Controllers\Web\DashboardController::class,'users'])->name('users');
    Route::get('/channels',[\App\Http\Controllers\Web\DashboardController::class,'channels'])->name('channels');
    Route::post('/channels',[\App\Http\Controllers\Web\DashboardController::class,'store'])->name('channels.store');
    Route::get('/profile',[\App\Http\Controllers\Web\DashboardController::class,'profile'])->name('profile');
    Route::get('/pricing',[\App\Http\Controllers\Web\DashboardController::class,'pricing'])->name('pricing');
    Route::get('/activity',[\App\Http\Controllers\Web\DashboardController::class,'activity'])->name('activity');
    Route::post('ajax/channels/update', [\App\Http\Controllers\Web\DashboardController::class, 'updateChannel'])->name('ajax.channels.update');
    Route::post('ajax/channels/delete', [\App\Http\Controllers\Web\DashboardController::class, 'deleteChannel'])->name('ajax.channels.delete');
    Route::post('ajax/accessKey/add', [\App\Http\Controllers\Web\DashboardController::class, 'addAccessKey'])->name('ajax.accessKeys.add');
    Route::post('ajax/accessKey/show', [\App\Http\Controllers\Web\DashboardController::class, 'showAccessKey'])->name('ajax.accessKeys.show');
    Route::post('ajax/profile/pic', [\App\Http\Controllers\Web\DashboardController::class, 'updateProfilePic'])->name('ajax.profile.pic');
    Route::post('ajax/profile/update', [\App\Http\Controllers\Web\DashboardController::class, 'updateProfile'])->name('ajax.profile.update');
    Route::post('ajax/liveChat/add', [\App\Http\Controllers\Web\DashboardController::class, 'addLiveChat'])->name('ajax.liveChat.add');
    Route::post('ajax/liveChat/show', [\App\Http\Controllers\Web\DashboardController::class, 'showLiveChat'])->name('ajax.liveChat.show');
});
Route::get('/facebook/callback',[\App\Http\Controllers\Providers\FacebookController::class,'callback']);
Route::get('/instagram/callback',[\App\Http\Controllers\Providers\InstagramController::class,'callback']);
Route::get('/linkedin/callback',[\App\Http\Controllers\Providers\LinkedinController::class,'callback']);
Route::get('/facebook/oauth/{account}',[\App\Http\Controllers\Providers\FacebookController::class,'guestCallback'])->name('facebook.oauth');
Route::get('/instagram/oauth/{account}',[\App\Http\Controllers\Providers\InstagramController::class,'guestCallback'])->name('instagram.oauth');
Route::get('/twitter/oauth/{account}',[\App\Http\Controllers\Providers\TwitterController::class,'guestCallback'])->name('twitter.oauth');
Route::get('/linkedin/oauth/{account}',[\App\Http\Controllers\Providers\LinkedinController::class,'guestCallback'])->name('linkedin.oauth');
Route::match(['get','post'],'/facebook/message',[\App\Http\Controllers\Providers\FacebookController::class,'receive'])->name('receiveFB');
Route::match(['get','post'],'/instagram/message',[\App\Http\Controllers\Providers\InstagramController::class,'receive'])->name('receiveIN');
Route::match(['get','post'],'/live/message',[\App\Http\Controllers\Providers\LiveChatController::class,'receive'])->name('receiveLV');
Route::post('/test',[\App\Http\Controllers\Providers\FacebookController::class,'receive']);
Route::match(['get','post'],'/forms/{id}',[\App\Http\Controllers\Api\FormsController::class,'formAdd'])->name('forms.responder');
Route::get('/2Oauth/{account}',[\App\Http\Controllers\Web\DashboardController::class,'connect'])->name('openId.connect');
Route::get('/reset/password',[\App\Http\Controllers\Web\ResetPasswordController::class,'resetPassword'])->name('reset.password');
Route::post('/reset/password/verify',[\App\Http\Controllers\Web\ResetPasswordController::class,'resetPasswordVerify'])->name('ajax.reset.password');
Route::match(['get','post'],'/reset/password/{token}/confirm',[\App\Http\Controllers\Web\ResetPasswordController::class,'resetPasswordConfirm'])->name('reset.password.confirm');
