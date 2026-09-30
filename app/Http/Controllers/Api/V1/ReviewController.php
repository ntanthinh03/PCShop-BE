<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Services\ReviewService;
use App\Traits\HasApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use HasApiResponse;

    public function __construct(public ReviewService $reviewService) {}

    public function index(Product $product, Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $reviews = $this->reviewService->getReviewsForProduct($product, $perPage);

        return $this->paginatedResponse($reviews, ReviewResource::collection($reviews));
    }

    public function store(StoreReviewRequest $request, Product $product): JsonResponse
    {
        try {
            $review = $this->reviewService->addReview($request->user(), $product, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully.',
                'data' => new ReviewResource($review),
            ], 201);
        } catch (QueryException $e) {
            $errorCode = (string) ($e->errorInfo[1] ?? $e->getCode());
            $sqlState = (string) ($e->errorInfo[0] ?? $e->getCode());
            $message = $e->getMessage();

            // Driver specific duplicate entry checks:
            // MySQL: Error 1062
            // PostgreSQL: SQLSTATE 23505
            // SQLite: 'UNIQUE constraint failed' message or error code 19
            $isDuplicate = $errorCode === '1062'
                || $sqlState === '23505'
                || str_contains($message, 'UNIQUE constraint failed')
                || str_contains($message, '1062');

            if ($isDuplicate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already reviewed this product.',
                ], 422);
            }

            throw $e;
        }
    }
}
