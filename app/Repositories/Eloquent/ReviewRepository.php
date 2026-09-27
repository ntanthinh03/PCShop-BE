<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function createReview(User $user, Product $product, array $data): Review
    {
        return Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ])->load('user');
    }

    public function getProductReviews(Product $product, int $perPage = 10): LengthAwarePaginator
    {
        return Review::with('user')
            ->where('product_id', $product->id)
            ->latest()
            ->paginate($perPage);
    }
}
