<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediasController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccessKeysController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\AuthorizationsController;
use App\Http\Controllers\RespondersController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SegmentsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\QuestionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['middleware' => 'EnsureTokenIsValid'], function () {
    Route::post('contact/segment/add', [ContactsController::class, 'addToSegment'])->name('contacts.addToSegment');
    Route::get('scopes', [AccessKeysController::class, 'scopes'])->name('accessKeys.scopes');
    Route::delete('contact/segment/delete', [ContactsController::class, 'deleteFromSegment'])->name('contacts.deleteFromSegment');
    Route::resource('medias', MediasController::class)->parameter('', 'media');
    Route::resource('accounts', AccountsController::class)->parameter('', 'account');
    Route::resource('accessKeys', AccessKeysController::class)->parameter('', 'accessKey');
    Route::resource('channels', ChannelsController::class)->parameter('', 'channel');
    Route::resource('fields', FieldsController::class)->parameter('', 'field');
    Route::resource('authorizations', AuthorizationsController::class)->parameter('', 'authorization');
    Route::resource('responders', RespondersController::class)->parameter('', 'responder');
    Route::resource('forms', FormsController::class)->parameter('', 'form');
    Route::resource('contacts', ContactsController::class)->parameter('', 'contact');
    Route::resource('profiles', ProfilesController::class)->parameter('', 'profile');
    Route::resource('segments', SegmentsController::class)->parameter('', 'segment');
    Route::resource('questions', QuestionsController::class)->parameter('', 'question');
    Route::resource('messages', MessagesController::class)->parameter('', 'message')->only([
        'index', 'show'
    ]);
    Route::resource('requests', RequestsController::class)->parameter('', 'request')->only([
        'index', 'show'
    ]);
    Route::resource('logs', LogsController::class)->parameter('', 'request')->only([
        'index', 'show'
    ]);
});
