<?php

namespace App\Services;

use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function __construct(public OrderRepositoryInterface $orderRepository) {}

    public function checkout(User $user, array $data): Order
    {
        $order = $this->orderRepository->createOrderWithItems([
            'user_id' => $user->id,
            'shipping_address' => $data['shipping_address'],
        ], $data['items']);

        // Gửi mail xác nhận đơn hàng qua Queue Worker (bất đồng bộ)
        Mail::to($user->email)->queue(new OrderPlacedMail($order));

        return $order;
    }

    public function getUserOrders(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->orderRepository->getUserOrderHistory($user, $perPage);
    }

    public function getOrderByCode(string $code): ?Order
    {
        return $this->orderRepository->findByCode($code);
    }

    public function updateOrderStatus(Order $order, string $status): bool
    {
        return $this->orderRepository->updateStatus($order, $status);
    }
}
