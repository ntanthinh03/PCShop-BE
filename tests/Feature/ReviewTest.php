<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $category = Category::create([
            'name' => 'Headphones',
            'slug' => 'headphones',
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sony WH-1000XM5',
            'slug' => 'sony-wh1000xm5',
            'sku' => 'AUD-SONY-XM5',
            'price' => 399.99,
            'stock_quantity' => 15,
        ]);
    }

    public function test_user_can_submit_product_review()
    {
        $payload = [
            'rating' => 5,
            'comment' => 'Excellent noise cancellation and sound quality!',
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/v1/products/{$this->product->id}/reviews", $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'rating' => 5,
                    'comment' => 'Excellent noise cancellation and sound quality!',
                ],
            ]);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 5,
        ]);
    }

    public function test_can_get_product_reviews_list()
    {
        Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 4,
            'comment' => 'Great product!',
        ]);

        $response = $this->getJson("/api/v1/products/{$this->product->id}/reviews");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'user_name', 'rating', 'comment', 'created_at'],
                ],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }
}
