<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/signup', [UserController::class, 'signup']);
    Route::post('/signin', [UserController::class, 'signin']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
});
