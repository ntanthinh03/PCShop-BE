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
        // Tạo tài khoản Admin mặc định
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'password' => bcrypt('admin123'),
                'role' => 'Admin',
            ]
        );

        // Tạo tài khoản Khách hàng mặc định
        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Nguyen Van A',
                'password' => bcrypt('password123'),
                'role' => 'Customer',
            ]
        );
    }
}
