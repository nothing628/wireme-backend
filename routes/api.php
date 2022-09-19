<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/chats', 'ChatController@listUserChat');
    Route::get('/messages', 'MessageController@listUserMessage');
    Route::post('/messages', 'MessageController@sendMessage');
    Route::get('/me', 'UserController@getUserProfile');
    Route::post('/me', 'UserController@updateUserProfile');
});
