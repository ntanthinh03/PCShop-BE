<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Handle user registration logic.
     *
     * @param array $data Contains validated registration data (name, email, password)
     * @return array
     */
    public function registerUser(array $data): array
    {
        // Sử dụng DB Transaction:
        // Đảm bảo nếu có lỗi xảy ra ở giữa chừng (ví dụ: tạo user thành công nhưng lỗi lúc tạo token),
        // hệ thống sẽ hoàn tác (rollback) lại toàn bộ, không lưu dữ liệu bị lỗi vào database.
        return DB::transaction(function () use ($data) {
            
            // 1. Tạo bản ghi User mới trong database
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                // Hash::make() dùng để mã hóa mật khẩu trước khi lưu vào DB (bắt buộc vì lý do bảo mật)
                'password' => Hash::make($data['password']),
            ]);

            // 2. Khởi tạo một Personal Access Token cho User vừa tạo
            // Token này sẽ được cấp cho client (FE, Mobile) dùng để gửi lên trong các request sau nhằm xác thực.
            $token = $user->createToken('auth_token')->plainTextToken;

            // 3. Trả về thông tin User và Token cho Controller
            return [
                'user' => $user,
                'token' => $token,
            ];
        });
    }
}
