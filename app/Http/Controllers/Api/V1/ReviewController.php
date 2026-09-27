<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(public ReviewService $reviewService) {}

    public function index(Product $product, Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $reviews = $this->reviewService->getReviewsForProduct($product, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => ReviewResource::collection($reviews),
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ],
        ], 200);
    }

    public function store(StoreReviewRequest $request, Product $product): JsonResponse
    {
        $review = $this->reviewService->addReview($request->user(), $product, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully.',
            'data' => new ReviewResource($review),
        ], 201);
    }
}
