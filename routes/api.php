<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index']);