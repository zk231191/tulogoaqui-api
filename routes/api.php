<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\CustomerController;
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
    });

    Route::prefix('/customers')->group(function(){
        Route::get('/', [CustomerController::class, 'showAll']);
        Route::post('/', [CustomerController::class, 'register']);
        Route::get('/{customer}', [CustomerController::class, 'show']);
        Route::put('/{customer}', [CustomerController::class, 'update']);
        Route::delete('/{customer}', [CustomerController::class, 'delete']);
    });
});
