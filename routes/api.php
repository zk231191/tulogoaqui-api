<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['message' => 'test']);
});

Route::post('/auth/login', [AuthController::class, 'login']);


Route::get('/users/me', function (Request $request) {
    $user = $request->user()->toArray();
    $user['roles'] = $request->user()->getRoleNames();
    $user['permissions'] = $request->user()->getAllPermissions()->pluck('name');
    return $user;
})->middleware('auth:sanctum');
