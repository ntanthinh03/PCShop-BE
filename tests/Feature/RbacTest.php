<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private User $admin;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create(['role' => 'Customer']);
        $this->admin = User::factory()->create(['role' => 'Admin']);

        $category = Category::create(['name' => 'Monitors', 'slug' => 'monitors']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'LG UltraGear 27"',
            'slug' => 'lg-ultragear-27',
            'sku' => 'MON-LG-27',
            'price' => 350.00,
            'stock_quantity' => 5,
        ]);

        $this->order = Order::create([
            'user_id' => $this->customer->id,
            'order_code' => 'ORD-TEST-001',
            'total_amount' => 350.00,
            'status' => 'Processing',
            'shipping_address' => 'Test Address',
        ]);
    }

    public function test_customer_cannot_update_order_status()
    {
        $response = $this->actingAs($this->customer)
            ->patchJson("/api/v1/admin/orders/{$this->order->id}/status", [
                'status' => 'Completed',
            ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Access denied. Unauthorized role permissions.',
            ]);
    }

    public function test_admin_can_update_order_status()
    {
        $response = $this->actingAs($this->admin)
            ->patchJson("/api/v1/admin/orders/{$this->order->id}/status", [
                'status' => 'Completed',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'status' => 'Completed',
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'Completed',
        ]);
    }
}
