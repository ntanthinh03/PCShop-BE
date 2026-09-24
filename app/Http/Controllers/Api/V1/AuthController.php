<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Constructor promotion (Tính năng của PHP 8)
     * Laravel (Dependency Injection) sẽ tự động đưa AuthService vào biến $authService
     */
    public function __construct(public AuthService $authService)
    {
    }

    /**
     * API Đăng ký tài khoản
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // 1. Dữ liệu khi lọt vào tới đây là đã hợp lệ hoàn toàn (nhờ RegisterRequest kiểm tra trước đó).
        // Hàm validated() sẽ lấy ra mảng dữ liệu sạch (name, email, password)
        $validatedData = $request->validated();

        // 2. Chuyển phần dữ liệu sạch cho AuthService xử lý (tạo db, tạo token).
        // Mô hình Service Pattern giúp Controller "mỏng" nhất có thể.
        $result = $this->authService->registerUser($validatedData);

        // 3. Trả về JSON thông báo thành công kèm HTTP Code 201 (Created)
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'data' => $result
        ], 201);
    }
}
