<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::prefix('catalog')->group(function () {
    Route::apiResource('books', BookController::class);
    Route::apiResource('tags', TagController::class);
});