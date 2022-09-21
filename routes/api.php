<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', [UserController::class, 'createUserToken']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/chats', [ChatController::class, 'listUserChat']);
    Route::post('/chats', [ChatController::class, 'initiateChat']);
    Route::get('/chats/{chat_id}/messages', [MessageController::class, 'listUserMessage']);
    Route::post('/chats/{chat_id}/messages', [MessageController::class, 'sendMessage']);
    Route::get('/me', [UserController::class, 'getUserProfile']);
    Route::post('/me', [UserController::class, 'updateUserProfile']);
    Route::post('/me/logout', [UserController::class, 'revokeUserToken']);
});
