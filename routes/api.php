<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Nhóm các route API liên quan đến Authentication (Phiên bản v1)
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Nhóm các route API yêu cầu phải có Token (đã đăng nhập)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Đăng xuất
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Danh mục & Sản phẩm
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);

    // Đơn hàng (Orders)
    Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    Route::get('/orders/history', [OrderController::class, 'history']);
    Route::get('/orders/{code}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);

    // Đánh giá sản phẩm (Reviews)
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
});

// Xem danh sách đánh giá sản phẩm (Công khai)
Route::get('/v1/products/{product}/reviews', [ReviewController::class, 'index']);

// Route mặc định sinh ra để lấy thông tin user hiện tại (cần truyền Token vào Header)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
