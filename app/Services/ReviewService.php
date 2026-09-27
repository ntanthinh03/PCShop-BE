<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewService
{
    public function __construct(public ReviewRepositoryInterface $reviewRepository) {}

    public function addReview(User $user, Product $product, array $data): Review
    {
        return $this->reviewRepository->createReview($user, $product, $data);
    }

    public function getReviewsForProduct(Product $product, int $perPage = 10): LengthAwarePaginator
    {
        return $this->reviewRepository->getProductReviews($product, $perPage);
    }
}
