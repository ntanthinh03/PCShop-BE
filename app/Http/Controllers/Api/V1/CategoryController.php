<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCategoryRequest;
use App\Http\Requests\Api\V1\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(public CategoryService $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json([
            'status' => 'success',
            'data' => CategoryResource::collection($categories),
        ], 200);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => new CategoryResource($category),
        ], 200);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $this->categoryService->updateCategory($category, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully.',
            'data' => new CategoryResource($category->fresh()),
        ], 200);
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully.',
        ], 200);
    }
}
