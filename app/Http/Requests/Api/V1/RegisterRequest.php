<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Luôn trả về true vì bất kỳ ai (khách) cũng có quyền gọi API đăng ký.
        // Nếu trả về false, request sẽ bị chặn ngay lập tức với lỗi 403 Forbidden.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Khai báo các quy tắc kiểm tra (validation) dữ liệu gửi lên.
        // Nếu dữ liệu không thỏa mãn, Laravel sẽ tự động ném ra lỗi 422 Unprocessable Entity
        // kèm thông báo lỗi chi tiết cho client.
        return [
            // 'name' bắt buộc có, là chuỗi, tối đa 255 ký tự
            'name' => ['required', 'string', 'max:255'],

            // 'email' bắt buộc có, định dạng email, tối đa 255 ký tự, 
            // và quan trọng nhất: phải duy nhất (unique) trong bảng 'users'.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            // 'password' bắt buộc có, chuỗi, độ dài tối thiểu 8 ký tự.
            // Rule 'confirmed' bắt buộc client phải gửi kèm trường 'password_confirmation' giống hệt 'password'.
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
