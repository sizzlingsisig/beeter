<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected route (requires Sanctum authentication)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // User info routes
    Route::post('/user-info', [UserInfoController::class, 'store']);
    Route::put('/user-info', [UserInfoController::class, 'update']);
    Route::get('/user-info', [UserInfoController::class, 'show']);

    // Categories: all authenticated users can view
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    Route::get('/my-posts', [PostController::class, 'myPosts']);
    Route::get('/liked-posts', [PostController::class, 'likedPosts']);
    Route::post('/likes', [LikeController::class, 'store']);


});

