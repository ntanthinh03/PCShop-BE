<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrderWithItems(array $orderData, array $itemsData): Order
    {
        return DB::transaction(function () use ($orderData, $itemsData) {
            $totalAmount = 0;
            $itemsToCreate = [];

            foreach ($itemsData as $item) {
                // Khóa dòng sản phẩm để tránh Race Condition (Pessimistic Locking)
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->firstOrFail();

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Product {$product->name} does not have enough stock.");
                }

                // Trừ tồn kho
                $product->decrement('stock_quantity', $item['quantity']);

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $itemsToCreate[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => $orderData['user_id'],
                'order_code' => 'ORD-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(3))),
                'total_amount' => $totalAmount,
                'status' => 'Processing',
                'shipping_address' => $orderData['shipping_address'],
            ]);

            foreach ($itemsToCreate as $item) {
                $order->items()->create($item);
            }

            return $order->load('items.product');
        });
    }

    public function getUserOrderHistory(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    public function findByCode(string $orderCode): ?Order
    {
        return Order::with('items.product')->where('order_code', $orderCode)->first();
    }

    public function updateStatus(Order $order, string $status): bool
    {
        return $order->update(['status' => $status]);
    }
}
