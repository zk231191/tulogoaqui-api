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
        Route::get('/', [ServicesController::class, 'index']);
        Route::post('/', [ServicesController::class, 'store']);
    });
});

Route::prefix('/customers')->group(function(){
    Route::post('/', [CustomerController::class, 'registerNewClient']);
    Route::get('/', [CustomerController::class, 'searchAllClients']);
    Route::get('/{id}', [CustomerController::class, 'searchClient']);
    Route::put('/{id}', [CustomerController::class, 'modifyAndUpdateClient']);
    Route::delete('/{id}', [CustomerController::class, 'deleteClient']);
});
