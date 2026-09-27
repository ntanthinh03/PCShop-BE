<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::create([
            'name' => 'Components',
            'slug' => 'components',
        ]);
    }

    public function test_can_get_paginated_products()
    {
        Product::create([
            'category_id' => $this->category->id,
            'name' => 'RTX 4090 GPU',
            'slug' => 'rtx-4090-gpu',
            'sku' => 'GPU-4090',
            'price' => 1999.99,
            'stock_quantity' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'name', 'slug', 'sku', 'price', 'stock_quantity'],
                ],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }

    public function test_can_create_product_with_tech_specs()
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $payload = [
            'category_id' => $this->category->id,
            'brand' => 'Intel',
            'name' => 'Intel Core i9 14900K',
            'slug' => 'intel-i9-14900k',
            'sku' => 'CPU-14900K',
            'description' => 'Flagship desktop CPU',
            'specs' => [
                'socket' => 'LGA1700',
                'cores' => 24,
                'threads' => 32,
                'base_clock' => '3.2 GHz',
                'boost_clock' => '6.0 GHz',
            ],
            'price' => 589.00,
            'stock_quantity' => 25,
        ];

        $response = $this->actingAs($admin)
            ->postJson('/api/v1/admin/products', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'brand' => 'Intel',
                    'name' => 'Intel Core i9 14900K',
                    'specs' => [
                        'socket' => 'LGA1700',
                        'cores' => 24,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'sku' => 'CPU-14900K',
            'brand' => 'Intel',
        ]);
    }

    public function test_can_show_product()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Samsung 990 Pro 2TB',
            'slug' => 'samsung-990-pro-2tb',
            'sku' => 'SSD-990PRO-2TB',
            'price' => 179.99,
            'stock_quantity' => 50,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $product->id,
                    'sku' => 'SSD-990PRO-2TB',
                ],
            ]);
    }

    public function test_can_update_product()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'DDR5 RAM 32GB',
            'slug' => 'ddr5-ram-32gb',
            'sku' => 'RAM-DDR5-32GB',
            'price' => 120.00,
            'stock_quantity' => 15,
        ]);

        $response = $this->actingAs($admin)
            ->putJson("/api/v1/admin/products/{$product->id}", [
                'price' => 109.99,
                'stock_quantity' => 20,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'price' => 109.99,
                    'stock_quantity' => 20,
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 20,
        ]);
    }

    public function test_can_delete_product()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Z790 Motherboard',
            'slug' => 'z790-motherboard',
            'sku' => 'MB-Z790',
            'price' => 249.99,
            'stock_quantity' => 8,
        ]);

        $response = $this->actingAs($admin)
            ->deleteJson("/api/v1/admin/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
