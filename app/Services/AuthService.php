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
    /**
     * Xử lý logic đăng nhập
     *
     * @param array $data Gồm email và password
     * @return array|null Trả về mảng user+token nếu thành công, null nếu thất bại
     */
    public function loginUser(array $data): ?array
    {
        // 1. Tìm user trong database dựa vào email
        $user = User::where('email', $data['email'])->first();

        // 2. Kiểm tra xem user có tồn tại không VÀ mật khẩu có khớp không
        // Hàm Hash::check sẽ tự động so sánh mật khẩu người dùng nhập vào với mật khẩu đã mã hóa trong DB
        if (!$user || !Hash::check($data['password'], $user->password)) {
            // Đăng nhập thất bại
            return null;
        }

        // 3. Đăng nhập thành công, tạo Token mới
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
