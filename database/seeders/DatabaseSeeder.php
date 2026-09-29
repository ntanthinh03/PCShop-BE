<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin môi trường Local/Dev
        User::firstOrCreate(
            ['email' => env('ADMIN_DEFAULT_EMAIL', 'admin@example.com')],
            [
                'name' => 'System Administrator',
                'password' => bcrypt(env('ADMIN_DEFAULT_PASSWORD', 'admin123')),
                'role' => 'Admin',
            ]
        );

        // Tạo tài khoản Khách hàng môi trường Local/Dev
        User::firstOrCreate(
            ['email' => env('CUSTOMER_DEFAULT_EMAIL', 'customer@example.com')],
            [
                'name' => 'Nguyen Van A',
                'password' => bcrypt(env('CUSTOMER_DEFAULT_PASSWORD', 'password123')),
                'role' => 'Customer',
            ]
        );
    }
}
