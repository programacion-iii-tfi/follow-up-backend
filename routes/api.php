<?php

use App\Interfaces\Http\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\User\Controllers\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('users',  [UserController::class, 'store']); // registro

    // Protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('users', UserController::class)->except(['store']);
    });
});