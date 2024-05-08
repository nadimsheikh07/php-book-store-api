<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

Route::get('books', [BookController::class, 'index']);
Route::apiResource('carts', CartController::class)->middleware('auth:api');