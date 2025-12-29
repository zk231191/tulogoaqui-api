<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Api\FiscalRegimeController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ServiceModesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\SseController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ZipCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/test/ably', function(Request $request, \App\Services\AblyService $ably) {
    $ably->publish(
        'orders',
        'order-created',
        [
            'hola' => 'ably',
            'mundo' => 'order'
        ]
    );

    return response()->json(['sent' => true]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/zip/{zip}', [ZipCodeController::class, 'show']);

    Route::get('/roles-with-permissions', [RoleController::class, 'index']);

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
        Route::put('/{serviceMode}', [ServiceModesController::class, 'update']);
        Route::delete('/{serviceMode}', [ServiceModesController::class, 'destroy']);
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/', [UsersController::class, 'store']);
        Route::get('/{user}', [UsersController::class, 'show']);
        Route::put('/{user}', [UsersController::class, 'update']);
        Route::delete('/{user}', [UsersController::class, 'destroy']);
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomersController::class, 'index']);
        Route::get('/{customer}', [CustomersController::class, 'show']);
        Route::post('/', [CustomersController::class, 'store']);
        Route::put('/{customer}', [CustomersController::class, 'update']);
        Route::delete('/{customer}', [CustomersController::class, 'destroy']);
    });

    Route::prefix('/fiscal-regiments')->group(function () {
        Route::get('/',[FiscalRegimeController::class, 'index']);
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/', [OrdersController::class, 'index']);
        Route::get('/{token}/public', [OrdersController::class, 'showPublic']);
        Route::get('/{order}', [OrdersController::class, 'show']);
        Route::post('/', [OrdersController::class, 'store']);
    });
});
