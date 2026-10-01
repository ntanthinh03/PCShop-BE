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

// =========================================================================
// 🌐 1. PUBLIC STOREFRONT API (Dành cho Website Khách hàng mua hàng)
// =========================================================================
Route::prefix('v1')->group(function () {
    // Xem Sản phẩm & Phân trang, Tìm kiếm, Lọc
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Xem Danh mục sản phẩm
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // Xem Đánh giá nhận xét sản phẩm
    Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);
});

// =========================================================================
// 🔐 2. CUSTOMER AUTHENTICATED API (Dành cho Người mua hàng đã Đăng nhập)
// =========================================================================
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Đăng xuất
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Đặt hàng & Xem lịch sử đơn hàng
    Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    Route::get('/orders/history', [OrderController::class, 'history']);
    Route::get('/orders/{code}', [OrderController::class, 'show']);

    // Viết đánh giá sản phẩm
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
});

// =========================================================================
// 🛡️ 3. ADMIN DASHBOARD API (Dành cho Website Admin Quản trị)
// =========================================================================
Route::prefix('v1/admin')->group(function () {
    // Quản lý Sản phẩm (Thêm / Sửa / Xóa)
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    // Quản lý Danh mục (Thêm / Sửa / Xóa)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // Quản lý Đơn hàng
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);

    // Quản lý Staff Nhân viên
    Route::get('/staff', function () {
        return response()->json(['status' => 'success', 'data' => []]);
    });
    Route::post('/staff', function (Request $request) {
        return response()->json(['status' => 'success', 'message' => 'Đã lưu thông tin staff vào hệ thống', 'data' => $request->all()]);
    });

    // Quản lý Phiếu Bảo Hành
    Route::get('/warranties', function () {
        return response()->json(['status' => 'success', 'data' => []]);
    });
    Route::post('/warranties', function (Request $request) {
        return response()->json(['status' => 'success', 'message' => 'Đã lưu phiếu bảo hành vào hệ thống', 'data' => $request->all()]);
    });
    Route::patch('/warranties/{id}/status', function (Request $request, $id) {
        return response()->json(['status' => 'success', 'message' => "Đã cập nhật trạng thái phiếu BH #{$id}", 'data' => $request->all()]);
    });

    // Quản lý System Audit Logs
    Route::get('/logs', function () {
        return response()->json(['status' => 'success', 'data' => []]);
    });
    Route::post('/logs', function (Request $request) {
        return response()->json(['status' => 'success', 'message' => 'Đã lưu log hệ thống', 'data' => $request->all()]);
    });
});

// Route lấy thông tin User hiện tại
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
