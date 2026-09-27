<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_can_get_list_of_categories()
    {
        Category::create(['name' => 'Laptops', 'slug' => 'laptops']);
        Category::create(['name' => 'Keyboards', 'slug' => 'keyboards']);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'name', 'slug', 'description'],
                ],
            ]);
    }

    public function test_can_create_category()
    {
        $payload = [
            'name' => 'Gaming PCs',
            'slug' => 'gaming-pcs',
            'description' => 'High performance PCs',
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/categories', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'name' => 'Gaming PCs',
                    'slug' => 'gaming-pcs',
                ],
            ]);

        $this->assertDatabaseHas('categories', [
            'slug' => 'gaming-pcs',
        ]);
    }

    public function test_can_show_category()
    {
        $category = Category::create(['name' => 'Monitors', 'slug' => 'monitors']);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $category->id,
                    'name' => 'Monitors',
                ],
            ]);
    }

    public function test_can_update_category()
    {
        $category = Category::create(['name' => 'Mice', 'slug' => 'mice']);

        $response = $this->actingAs($this->user)
            ->putJson("/api/v1/categories/{$category->id}", [
                'name' => 'Wireless Mice',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'name' => 'Wireless Mice',
                ],
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Wireless Mice',
        ]);
    }

    public function test_can_delete_category()
    {
        $category = Category::create(['name' => 'Audio', 'slug' => 'audio']);

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/categories/{$category->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
