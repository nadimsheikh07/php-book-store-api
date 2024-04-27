<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/signup', [UserController::class, 'signup']);
    Route::post('/signin', [UserController::class, 'signin']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
});
