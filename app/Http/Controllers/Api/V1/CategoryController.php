<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Lấy danh sách danh mục
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Tạo danh mục mới
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => new CategoryResource($category)
        ], 201);
    }

    public function show(string $id) { /* Để sau */ }
    public function update(Request $request, string $id) { /* Để sau */ }
    public function destroy(string $id) { /* Để sau */ }
}
