<?php

namespace App\Services;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    /**
     * Constructor promotion
     * Tiêm (Inject) Interface của Repository vào Service.
     * Nhờ vậy, Service không cần biết DB là gì, nó chỉ gọi các hàm đã định nghĩa trong Interface.
     */
    public function __construct(public UserRepositoryInterface $userRepository) {}

    /**
     * Handle user registration logic.
     *
     * @param  array  $data  Contains validated registration data (name, email, password)
     */
    public function registerUser(array $data): array
    {
        // Sử dụng DB Transaction:
        // Đảm bảo nếu có lỗi xảy ra ở giữa chừng (ví dụ: tạo user thành công nhưng lỗi lúc tạo token),
        // hệ thống sẽ hoàn tác (rollback) lại toàn bộ, không lưu dữ liệu bị lỗi vào database.
        return DB::transaction(function () use ($data) {

            // 1. Tạo bản ghi User thông qua Repository (không gọi Model trực tiếp nữa)
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
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
     * @param  array  $data  Gồm email và password
     * @return array|null Trả về mảng user+token nếu thành công, null nếu thất bại
     */
    public function loginUser(array $data): ?array
    {
        // 1. Tìm user thông qua Repository thay vì chọc thẳng vào DB
        $user = $this->userRepository->findByEmail($data['email']);

        // 2. Kiểm tra xem user có tồn tại không VÀ mật khẩu có khớp không
        // Hàm Hash::check sẽ tự động so sánh mật khẩu người dùng nhập vào với mật khẩu đã mã hóa trong DB
        if (! $user || ! Hash::check($data['password'], $user->password)) {
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

    /**
     * Xử lý gửi mã OTP quên mật khẩu
     */
    public function forgotPassword(array $data): bool
    {
        // 1. Tạo OTP 6 số
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // 2. Lưu vào bảng password_reset_tokens (xóa mã cũ nếu có)
        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $data['email'],
            'token' => $otp, // Ở thực tế người ta mã hóa Hash::make($otp), nhưng đây ta lưu raw cho dễ test
            'created_at' => now(),
        ]);

        // 3. Gửi Email chứa OTP (dùng Brevo SMTP)
        Mail::to($data['email'])->send(new ResetPasswordMail($otp));

        return true;
    }

    /**
     * Xử lý xác nhận OTP và đổi mật khẩu mới
     */
    public function resetPassword(array $data): bool
    {
        // 1. Kiểm tra mã OTP trong DB
        $record = DB::table('password_reset_tokens')
            ->where('email', $data['email'])
            ->where('token', $data['otp'])
            ->first();

        // OTP sai hoặc không tồn tại
        if (! $record) {
            return false;
        }

        // 2. Cập nhật mật khẩu mới thông qua Repository
        $user = $this->userRepository->findByEmail($data['email']);
        $user->update(['password' => Hash::make($data['password'])]);

        // 3. Xóa OTP đã sử dụng
        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return true;
    }

    /**
     * Xử lý đăng xuất (Xóa token hiện tại)
     */
    public function logoutUser(User $user): void
    {
        // Xóa Token hiện tại mà người dùng đang sử dụng để gửi request
        $user->currentAccessToken()->delete();
    }
}
