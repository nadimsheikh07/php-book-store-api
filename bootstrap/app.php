<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::namespace ('App\Http\Controllers\Api')->prefix('api')->name('api.')->group(base_path('routes/api.php'));
            Route::namespace ('App\Http\Controllers\Auth')->prefix('auth')->name('auth.')->group(base_path('routes/auth.php'));
            Route::namespace ('App\Http\Controllers\Admin')->prefix('admin')->middleware(['auth:api'])->name('admin.')->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
