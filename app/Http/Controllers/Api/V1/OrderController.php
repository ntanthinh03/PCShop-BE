<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService) {}

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->checkout($request->user(), $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully.',
                'data' => new OrderResource($order),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function history(Request $request): JsonResponse
    {
        $orders = $this->orderService->getUserOrders($request->user());

        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ], 200);
    }

    public function show(string $code): JsonResponse
    {
        $order = $this->orderService->getOrderByCode($code);

        if (! $order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], 200);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:Processing,Completed,Cancelled',
        ]);

        $this->orderService->updateOrderStatus($order, $request->get('status'));

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated successfully.',
            'data' => new OrderResource($order->fresh()->load('items.product')),
        ], 200);
    }
}
