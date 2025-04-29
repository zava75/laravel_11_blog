<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{

    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all(): LengthAwarePaginator
    {
       return $this->categoryRepository->all();
    }

    public function getInactiveCategories(): LengthAwarePaginator
    {
        return $this->categoryRepository->getInactiveCategories();
    }

    public function create(array $data): bool
    {
        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return false;
        }

        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return false;
        }

        return $category->delete();
    }

    public function activate(int $id): bool
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return false;
        }
        $category->is_active = true;

        return $category->save();
    }

    public function deactivate(int $id): bool
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return false;
        }
        $category->is_active = false;

        return $category->save();
    }

    public function find(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function getCategoryBySlug(string $slug): Category
    {
        if (!config('cache.enable')) {
            return $this->categoryRepository->findBySlug($slug);
        }

        $cacheKey = "category_slug_{$slug}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () use ($slug) {
            return $this->categoryRepository->findBySlug($slug);
        });
    }

    public function getMenuCategories(): Collection
    {
        if (!config('cache.enable')) {
            return $this->categoryRepository->getForMenu();
        }
        $cacheKey = "menu_categories";
        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () {
            return $this->categoryRepository->getForMenu();
        });
    }

    public function getRootCategories():Collection
    {
        return $this->categoryRepository->getRootCategories();
    }

    public function getRootCategoriesExcept(int $id):Collection
    {
        return $this->categoryRepository->getRootCategoriesExcept($id);
    }

    public function getSubCategories():Collection
    {
        return $this->categoryRepository->getSubCategories();
    }

}
