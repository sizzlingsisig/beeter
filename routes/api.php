<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\CategoryController;



// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected route (requires Sanctum authentication)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//user info
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user-info', [UserInfoController::class, 'store']);
    Route::put('/user-info', [UserInfoController::class, 'update']);
    Route::get('/user-info', [UserInfoController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Public access: all authenticated users
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // Admin-only access
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    });
});
