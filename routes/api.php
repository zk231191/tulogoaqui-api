<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\ServiceModesController;
use App\Http\Controllers\API\ServicesController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'user']);
    });

    Route::prefix('/services')->group(function () {
        Route::prefix('/modes')->group(function () {
            Route::prefix('/types')->group(function () {
                Route::get('/', [ServicesController::class, 'modeTypes']);
            });
        });

        Route::get('/', [ServicesController::class, 'index']);
        Route::post('/', [ServicesController::class, 'store']);

        Route::post('/{service}/modes', [ServicesController::class, 'storeModesAndPrices']);
        Route::delete('/{service}/modes/{mode}', [ServicesController::class, 'destroyModesAndPrices']);

        Route::put('/{service}', [ServicesController::class, 'update']);
        Route::delete('/{service}', [ServicesController::class, 'destroy']);
    });

    Route::prefix('/services-modes')->group(function () {
        Route::delete('/{serviceMode}', [ServiceModesController::class, 'destroy']);
    });
});

