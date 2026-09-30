<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(public CategoryRepositoryInterface $categoryRepository) {}

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(Category $category, array $data): bool
    {
        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory(Category $category): bool
    {
        return DB::transaction(function () use ($category): bool {
            $category->products()->delete();

            return $this->categoryRepository->delete($category);
        });
    }
}
