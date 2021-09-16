<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediasController;
use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\AccessKeysController;
use App\Http\Controllers\Api\ChannelsController;
use App\Http\Controllers\Api\FieldsController;
use App\Http\Controllers\Api\AuthorizationsController;
use App\Http\Controllers\Api\RespondersController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\ProfilesController;
use App\Http\Controllers\Api\SegmentsController;
use App\Http\Controllers\Api\RequestsController;
use App\Http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\LogsController;
use App\Http\Controllers\Api\FormsController;
use App\Http\Controllers\Api\QuestionsController;

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

Route::middleware(['EnsureTokenIsValid'])->group(function (){
    Route::post('contact/segment/add', [ContactsController::class, 'addToSegment'])->name('contacts.addToSegment');
    Route::get('scopes', [AccessKeysController::class, 'scopes'])->name('accessKeys.scopes');
    Route::delete('contact/segment/delete', [ContactsController::class, 'deleteFromSegment'])->name('contacts.deleteFromSegment');
    Route::prefix('medias')->group(function () {
        Route::get('', [MediasController::class, 'index'])->name('medias.index');
        Route::get('{media}', [MediasController::class, 'show'])->name('medias.show');
        Route::post('add', [MediasController::class, 'store'])->name('medias.store');
        Route::delete('{media}/delete', [MediasController::class, 'destroy'])->name('medias.delete');
        Route::put('{media}/update', [MediasController::class, 'update'])->name('medias.update');
    });
    Route::prefix('accounts')->group(function () {
        Route::get('', [AccountsController::class, 'index'])->name('accounts.index');
        Route::get('{account}', [AccountsController::class, 'show'])->name('accounts.show');
        Route::post('add', [AccountsController::class, 'store'])->name('accounts.store');
        Route::delete('{account}/delete', [AccountsController::class, 'destroy'])->name('accounts.delete');
        Route::put('{account}/update', [AccountsController::class, 'update'])->name('accounts.update');
    });
    Route::prefix('accessKeys')->group(function () {
        Route::get('', [AccessKeysController::class, 'index'])->name('accessKeys.index');
        Route::get('{accessKey}', [AccessKeysController::class, 'show'])->name('accessKeys.show');
        Route::post('add', [AccessKeysController::class, 'store'])->name('accessKeys.store');
        Route::delete('{accessKey}/delete', [AccessKeysController::class, 'destroy'])->name('accessKeys.delete');
        Route::put('{accessKey}/update', [AccessKeysController::class, 'update'])->name('accessKeys.update');
    });
    Route::prefix('channels')->group(function () {
        Route::get('', [ChannelsController::class, 'index'])->name('channels.index');
        Route::get('{channel}', [ChannelsController::class, 'show'])->name('channels.show');
        Route::post('add', [ChannelsController::class, 'store'])->name('channels.store');
        Route::delete('{channel}/delete', [ChannelsController::class, 'destroy'])->name('channels.delete');
        Route::put('{channel}/update', [ChannelsController::class, 'update'])->name('channels.update');
    });
    Route::prefix('fields')->group(function () {
        Route::get('', [FieldsController::class, 'index'])->name('fields.index');
        Route::get('{field}', [FieldsController::class, 'show'])->name('fields.show');
        Route::post('add', [FieldsController::class, 'store'])->name('fields.store');
        Route::delete('{field}/delete', [FieldsController::class, 'destroy'])->name('fields.delete');
        Route::put('{field}/update', [FieldsController::class, 'update'])->name('fields.update');
    });
    Route::prefix('authorizations')->group(function () {
        Route::get('', [AuthorizationsController::class, 'index'])->name('authorizations.index');
        Route::get('{authorization}', [AuthorizationsController::class, 'show'])->name('authorizations.show');
        Route::post('add', [AuthorizationsController::class, 'create'])->name('authorizations.create');
        Route::delete('{authorization}/delete', [AuthorizationsController::class, 'destroy'])->name('authorizations.delete');
        Route::put('{authorization}/update', [AuthorizationsController::class, 'update'])->name('authorizations.update');
    });
    Route::prefix('responders')->group(function () {
        Route::get('', [RespondersController::class, 'index'])->name('responders.index');
        Route::get('{responder}', [RespondersController::class, 'show'])->name('responders.show');
        Route::post('add', [RespondersController::class, 'store'])->name('responders.store');
        Route::delete('{responder}/delete', [RespondersController::class, 'destroy'])->name('responders.delete');
        Route::put('{responder}/update', [RespondersController::class, 'update'])->name('responders.update');
    });
    Route::prefix('forms')->group(function () {
        Route::get('', [FormsController::class, 'index'])->name('forms.index');
        Route::get('{form}', [FormsController::class, 'show'])->name('forms.show');
        Route::post('add', [FormsController::class, 'store'])->name('forms.store');
        Route::delete('{form}/delete', [FormsController::class, 'destroy'])->name('forms.delete');
        Route::put('{form}/update', [FormsController::class, 'update'])->name('forms.update');
    });
    Route::prefix('contacts')->group(function () {
        Route::get('', [ContactsController::class, 'index'])->name('contacts.index');
        Route::get('{contact}', [ContactsController::class, 'show'])->name('contacts.show');
        Route::post('add', [ContactsController::class, 'create'])->name('contacts.create');
        Route::delete('{contact}/delete', [ContactsController::class, 'destroy'])->name('contacts.delete');
        Route::put('{contact}/update', [ContactsController::class, 'update'])->name('contacts.update');
    });
    Route::prefix('profiles')->group(function () {
        Route::get('', [ProfilesController::class, 'index'])->name('profiles.index');
        Route::get('{profile}', [ProfilesController::class, 'show'])->name('profiles.show');
        Route::post('add', [ProfilesController::class, 'store'])->name('profiles.store');
        Route::delete('{profile}/delete', [ProfilesController::class, 'destroy'])->name('profiles.delete');
        Route::put('{profile}/update', [ProfilesController::class, 'update'])->name('profiles.update');
    });
    Route::prefix('segments')->group(function () {
        Route::get('', [SegmentsController::class, 'index'])->name('segments.index');
        Route::get('{segment}', [SegmentsController::class, 'show'])->name('segments.show');
        Route::post('add', [SegmentsController::class, 'store'])->name('segments.store');
        Route::delete('{segment}/delete', [SegmentsController::class, 'destroy'])->name('segments.delete');
        Route::put('{segment}/update', [SegmentsController::class, 'update'])->name('segments.update');
    });
    Route::prefix('questions')->group(function () {
        Route::get('', [QuestionsController::class, 'index'])->name('questions.index');
        Route::get('{question}', [QuestionsController::class, 'show'])->name('questions.show');
        Route::post('add', [QuestionsController::class, 'store'])->name('questions.store');
        Route::delete('{question}/delete', [QuestionsController::class, 'destroy'])->name('questions.delete');
        Route::put('{question}/update', [QuestionsController::class, 'update'])->name('questions.update');
    });
    Route::prefix('messages')->group(function () {
        Route::get('', [MessagesController::class, 'index'])->name('messages.index');
        Route::get('{message}', [MessagesController::class, 'show'])->name('messages.show');
    });
    Route::prefix('requests')->group(function () {
        Route::get('', [RequestsController::class, 'index'])->name('requests.index');
        Route::get('{request}', [RequestsController::class, 'show'])->name('requests.show');
    });
    Route::prefix('logs')->group(function () {
        Route::get('', [LogsController::class, 'index'])->name('logs.index');
        Route::get('{request}', [LogsController::class, 'show'])->name('logs.show');
    });
});
