<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BranchesController;
use App\Http\Controllers\API\CustomersController;
use App\Http\Controllers\FiscalAddressesController;
use App\Http\Controllers\API\FiscalAddressesController as APIFiscalAddressesController;
use App\Http\Controllers\API\FiscalRegimeController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\API\OrderPaymentsController;
use App\Http\Controllers\API\OrderStatusesController;
use App\Http\Controllers\API\OrderServicesController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\ReportsController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RolePermissionController;
use App\Http\Controllers\API\ServiceModesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ZipCodeController;
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

Route::get('/orders/{token}/public', [OrdersController::class, 'showPublic']);

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
        Route::put('/password', [UsersController::class, 'changePassword']);

        Route::get('/', [UsersController::class, 'index']);
        Route::post('/', [UsersController::class, 'store']);
        Route::get('/{user}', [UsersController::class, 'show']);
        Route::put('/{user}', [UsersController::class, 'update']);
        Route::delete('/{user}', [UsersController::class, 'destroy']);

    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomersController::class, 'index']);
        Route::post('/', [CustomersController::class, 'store']);

        Route::prefix('/{customer}')->group(function () {
            Route::get('/', [CustomersController::class, 'show']);
            Route::put('/', [CustomersController::class, 'update']);
            Route::delete('/', [CustomersController::class, 'destroy']);

            Route::prefix('/fiscal-address')->group(function () {
                Route::post('/', [FiscalAddressesController::class, 'store']);
                Route::put('/{fiscalAddress}', [APIFiscalAddressesController::class, 'update']);
                Route::delete('/{fiscalAddress}', [APIFiscalAddressesController::class, 'destroy']);
            });
        });

    });

    Route::prefix('/fiscal-regiments')->group(function () {
        Route::get('/',[FiscalRegimeController::class, 'index']);
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/', [OrdersController::class, 'index']);
        Route::get('/{order}', [OrdersController::class, 'show']);
        Route::post('/', [OrdersController::class, 'store']);
        Route::post('/{order}/payments', [OrderPaymentsController::class, 'store']);
        Route::put('/{order}/status', [OrdersController::class, 'updateStatus']);
    });

    Route::prefix('/payments')->group(function () {
        Route::get('/methods', [PaymentsController::class, 'methods']);
    });

    Route::prefix('/roles-permissions')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index']);
        Route::post('/', [RolePermissionController::class, 'store']);
        Route::put('/{role}', [RolePermissionController::class, 'update']);
        Route::put('/{role}/permissions', [RolePermissionController::class, 'updatePermissions']);
        Route::delete('/{role}', [RolePermissionController::class, 'destroy']);
    });

    Route::prefix('/reports')->group(function () {
        Route::get('/sellers', [ReportsController::class, 'sellers']);
    });

    Route::prefix('/order-statuses')->group(function () {
        Route::get('/', [OrderStatusesController::class, 'index']);
    });

    Route::prefix('/order-services')->group(function () {

        Route::prefix('/statuses')->group(function () {
            Route::get('/', [OrderServicesController::class, 'statuses']);
            Route::put('/{orderService}/status', [OrderServicesController::class, 'updateStatus']);
        });

        Route::prefix('/substatuses')->group(function () {
            Route::get('/', [OrderServicesController::class, 'substatuses']);
            Route::put('/{orderServiceItem}/substatus', [OrderServicesController::class, 'updateSubstatus']);
        });
    });

    Route::prefix('/branches')->group(function () {
        Route::get('/', [BranchesController::class, 'index']);
    });
});
