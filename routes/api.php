<?php
    Route::middleware('auth:api')->group(function () {
        /** Auth */
        Route::prefix('auth')->group(function () {
            Route::post('/my_info', [\App\Http\Controllers\Api\AuthController::class, 'register']);
            Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        });

        Route::prefix('message')->group(function () {
            Route::get('/get', [\App\Http\Controllers\Api\MessageController::class, 'get']);
            Route::post('/send_message', [\App\Http\Controllers\Api\MessageController::class, 'send_message']);
            Route::post('/mark_as_seen', [\App\Http\Controllers\Api\MessageController::class, 'mark_as_seen']);

        });

    });

    /** Auth */
    Route::prefix('auth')->group(function () {
        Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
        Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    });

