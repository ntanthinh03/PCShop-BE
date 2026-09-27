<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $itemsData): Order;

    public function getUserOrderHistory(User $user, int $perPage = 10): LengthAwarePaginator;

    public function findByCode(string $orderCode): ?Order;

    public function updateStatus(Order $order, string $status): bool;
}
