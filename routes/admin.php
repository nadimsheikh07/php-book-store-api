<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::prefix('catalog')->group(function () {
    Route::apiResource('books', BookController::class);
    Route::apiResource('tags', TagController::class);
});