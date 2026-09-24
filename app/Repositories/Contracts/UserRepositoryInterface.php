<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Tìm User theo email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Tạo mới User
     */
    public function create(array $data): User;
}
