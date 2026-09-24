<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

// Nhóm các route API liên quan đến Authentication (Phiên bản v1)
Route::prefix('v1/auth')->group(function () {
    // Gọi method 'register' trong AuthController khi có request POST lên /api/v1/auth/register
    Route::post('/register', [AuthController::class, 'register']);
});

// Route mặc định sinh ra để lấy thông tin user hiện tại (cần truyền Token vào Header)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
