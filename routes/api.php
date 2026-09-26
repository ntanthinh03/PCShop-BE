<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Nhóm các route API liên quan đến Authentication (Phiên bản v1)
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Nhóm các route API liên quan đến Danh mục (Categories) - Yêu cầu phải có Token (đã đăng nhập)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);
});

// Route mặc định sinh ra để lấy thông tin user hiện tại (cần truyền Token vào Header)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
