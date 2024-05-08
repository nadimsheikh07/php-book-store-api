<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Route;

Route::post('signup', [UserController::class, 'signup']);
Route::post('signin', [UserController::class, 'signin']);
Route::get('profile', [UserController::class, 'profile'])->middleware('auth:api');