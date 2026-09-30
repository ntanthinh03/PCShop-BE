<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreProductRequest;
use App\Http\Requests\Api\V1\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\HasApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HasApiResponse;

    public function __construct(public ProductService $productService) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'category_id', 'category', 'category_slug']);
        $perPage = (int) $request->get('per_page', 15);

        $products = $this->productService->getPaginatedProducts($filters, $perPage);

        return $this->paginatedResponse($products, ProductResource::collection($products));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'data' => new ProductResource($product->loadMissing('category')),
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product->loadMissing('category')),
        ], 200);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $this->productService->updateProduct($product, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product->fresh('category')),
        ], 200);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product);

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.',
        ], 200);
    }
}
