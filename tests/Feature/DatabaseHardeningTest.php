<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Requests\Api\V1\StoreReviewRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Services\CategoryService;
use App\Services\ReviewService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_deletion_nulls_user_id_and_preserves_order()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Laptops', 'slug' => 'laptops']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Laptop A',
            'slug' => 'laptop-a',
            'sku' => 'LAP-A',
            'price' => 1000,
            'stock_quantity' => 10,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-TEST-001',
            'total_amount' => 1000,
            'shipping_address' => 'Test Address',
        ]);

        $user->delete();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => null,
            'order_code' => 'ORD-TEST-001',
        ]);
    }

    public function test_deleting_category_or_product_uses_soft_deletes_preserving_historical_records()
    {
        $category = Category::create(['name' => 'Monitors', 'slug' => 'monitors']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Monitor 4K',
            'slug' => 'monitor-4k',
            'sku' => 'MON-4K',
            'price' => 500,
            'stock_quantity' => 5,
        ]);

        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $product->id]);

        $category->delete();

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    public function test_order_item_product_deletion_is_restricted_or_soft_deleted()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'RAM', 'slug' => 'ram']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'DDR4 RAM 16GB',
            'slug' => 'ddr4-ram-16gb',
            'sku' => 'RAM-16GB',
            'price' => 80,
            'stock_quantity' => 20,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-TEST-002',
            'total_amount' => 80,
            'shipping_address' => 'Test Address',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 80,
            'subtotal' => 80,
        ]);

        // Trying forceDelete on a product tied to an order item throws query exception (restrictOnDelete)
        $this->expectException(QueryException::class);
        $product->forceDelete();
    }

    public function test_user_cannot_review_same_product_multiple_times()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Audio', 'slug' => 'audio']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Headset',
            'slug' => 'headset',
            'sku' => 'AUD-HEADSET',
            'price' => 50,
            'stock_quantity' => 10,
        ]);

        $response1 = $this->actingAs($user)->postJson("/api/v1/products/{$product->id}/reviews", [
            'rating' => 5,
            'comment' => 'First review',
        ]);

        $response1->assertStatus(201);

        $response2 = $this->actingAs($user)->postJson("/api/v1/products/{$product->id}/reviews", [
            'rating' => 4,
            'comment' => 'Second review',
        ]);

        $response2->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'You have already reviewed this product.',
            ]);
    }

    public function test_non_duplicate_database_error_is_not_mapped_to_duplicate_review_response()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Gears', 'slug' => 'gears']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Mouse Pad',
            'slug' => 'mouse-pad',
            'sku' => 'PAD-01',
            'price' => 10,
            'stock_quantity' => 100,
        ]);

        $mockRepo = $this->createMock(ReviewRepositoryInterface::class);
        $genericDbException = new QueryException(
            'connection',
            'INSERT INTO reviews ...',
            [],
            new \Exception('General database connection error', 2002)
        );

        $mockRepo->expects($this->once())
            ->method('createReview')
            ->willThrowException($genericDbException);

        $service = new ReviewService($mockRepo);
        $controller = new ReviewController($service);

        $request = StoreReviewRequest::create(
            "/api/v1/products/{$product->id}/reviews",
            'POST',
            ['rating' => 5, 'comment' => 'Test comment']
        );
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make(Redirector::class));
        $request->setUserResolver(fn () => $user);
        $request->validateResolved();

        $this->expectException(QueryException::class);
        $controller->store($request, $product);
    }

    public function test_hashed_otp_token_with_expiry()
    {
        $user = User::factory()->create(['email' => 'otpuser@example.com']);

        // 1. Generate OTP
        $this->postJson('/api/v1/auth/forgot-password', ['email' => 'otpuser@example.com'])
            ->assertStatus(200);

        $tokenRecord = DB::table('password_reset_tokens')->where('email', 'otpuser@example.com')->first();

        $this->assertNotNull($tokenRecord);
        $this->assertNotEquals('123456', $tokenRecord->token); // Token must be hashed, not raw

        // 2. Test expired token (> 15 minutes)
        DB::table('password_reset_tokens')
            ->where('email', 'otpuser@example.com')
            ->update(['created_at' => now()->subMinutes(20)]);

        $expiredReset = $this->postJson('/api/v1/auth/reset-password', [
            'email' => 'otpuser@example.com',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $expiredReset->assertStatus(400);
    }

    public function test_soft_deleted_product_remains_in_order_history()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Storage', 'slug' => 'storage']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'External Hard Drive 2TB',
            'slug' => 'ext-hdd-2tb',
            'sku' => 'HDD-2TB',
            'price' => 120.00,
            'stock_quantity' => 10,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD-HISTORY-001',
            'total_amount' => 120.00,
            'shipping_address' => '456 History Lane',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 120.00,
            'subtotal' => 120.00,
        ]);

        // Soft delete the product
        $product->delete();
        $this->assertSoftDeleted('products', ['id' => $product->id]);

        // Query order history API endpoint
        $response = $this->actingAs($user)->getJson('/api/v1/orders/history');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    [
                        'id' => $order->id,
                        'items' => [
                            [
                                'product_id' => $product->id,
                                'product_name' => 'External Hard Drive 2TB',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function test_deleting_category_soft_deletes_attached_products()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $category = Category::create(['name' => 'Peripherals', 'slug' => 'peripherals']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'USB Hub',
            'slug' => 'usb-hub',
            'sku' => 'ACC-HUB',
            'price' => 15.00,
            'stock_quantity' => 30,
        ]);

        $this->actingAs($admin)->deleteJson("/api/v1/admin/categories/{$category->id}")
            ->assertStatus(200);

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_category_deletion_rolls_back_product_deletions_on_failure()
    {
        $category = Category::create(['name' => 'Failing Cat', 'slug' => 'failing-cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Product X',
            'slug' => 'product-x',
            'sku' => 'PROD-X',
            'price' => 20.00,
            'stock_quantity' => 5,
        ]);

        $mockRepo = $this->createMock(CategoryRepositoryInterface::class);
        $mockRepo->expects($this->once())
            ->method('delete')
            ->willThrowException(new \Exception('Database write error'));

        $service = new CategoryService($mockRepo);

        try {
            $service->deleteCategory($category);
            $this->fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            $this->assertEquals('Database write error', $e->getMessage());
        }

        // Verify transaction rolled back: product is NOT soft-deleted
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
    }
}
