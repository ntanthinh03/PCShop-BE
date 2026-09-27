<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewRepositoryInterface
{
    public function createReview(User $user, Product $product, array $data): Review;

    public function getProductReviews(Product $product, int $perPage = 10): LengthAwarePaginator;
}
