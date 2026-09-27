<?php

namespace Tests\Feature;

use App\Mail\OrderPlacedMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $category = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'name' => 'MacBook Pro M3',
            'slug' => 'macbook-pro-m3',
            'sku' => 'LAP-MBP-M3',
            'price' => 2000.00,
            'stock_quantity' => 10,
        ]);
    }

    public function test_user_can_checkout_order_successfully()
    {
        Mail::fake();

        $payload = [
            'shipping_address' => '123 Main Street, NY',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/orders/checkout', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'total_amount' => 4000.00,
                    'status' => 'Processing',
                    'shipping_address' => '123 Main Street, NY',
                ],
            ]);

        // Kiểm tra tồn kho đã bị trừ từ 10 -> 8
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'stock_quantity' => 8,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total_amount' => 4000.00,
        ]);

        // Kiểm tra Mail OrderPlacedMail được đẩy vào Queue thành công
        Mail::assertQueued(OrderPlacedMail::class);
    }

    public function test_checkout_fails_when_stock_is_insufficient()
    {
        $payload = [
            'shipping_address' => '123 Main Street, NY',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 50, // Nhiều hơn tồn kho 10
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/orders/checkout', $payload);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
            ]);

        // Tồn kho không thay đổi
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'stock_quantity' => 10,
        ]);
    }

    public function test_user_can_view_order_history()
    {
        // Đặt 1 đơn hàng trước
        $this->actingAs($this->user)->postJson('/api/v1/orders/checkout', [
            'shipping_address' => '123 Main St',
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 1],
            ],
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/orders/history');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'order_code', 'total_amount', 'status', 'items'],
                ],
            ]);
    }
}
