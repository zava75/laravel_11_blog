<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function all(): LengthAwarePaginator
    {
        return Category::select('id', 'name', 'slug', 'parent_id', 'is_active', 'title', 'description')
            ->withCount('posts')
            ->with(['children' => function ($query) {
                $query->select('id', 'name', 'slug', 'parent_id', 'is_active', 'title', 'description')
                    ->withCount('posts');
            }])
            ->whereNull('parent_id')
            ->paginate(20);
    }

    public function getInactiveCategories(): LengthAwarePaginator
    {
        return Category::query()->where('is_active', false)
            ->paginate(20);
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): bool
    {
        $category = Category::query()->create($data);

        return $category->exists;
    }

    public function update(array $data, int $id): bool
    {
        $category = Category::find($id);
        if (!$category) {
            return false;
        }

        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        $category = Category::query()->findOrFail($id);

        return $category->delete();
    }

    public function activate(int $id): bool
    {
        $category = Category::find($id);
        $category->is_active = true;

        return $category->save();
    }

    public function deactivate(int $id): bool
    {
        $category = Category::find($id);
        $category->is_active = false;

        return $category->save();
    }

    public function findBySlug(string $slug): Category
    {
        return Category::query()
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('parent_id')
                ->orWhereHas('parent', function ($q) {
                    $q->where('is_active', 1);
                });
            })
            ->firstOrFail();
    }

    public function getForMenu(): Collection
    {
            return Category::query()
                ->select('id', 'name', 'parent_id', 'slug')
                ->where('is_active', 1)
                ->whereNull('parent_id')
                ->with([
                    'children' => function ($query) {
                        $query->select('id', 'name', 'parent_id', 'slug')
                            ->where('is_active', 1);
                    }
                ])
                ->get();
    }

    public function getRootCategories(): Collection
    {
        return Category::query()->select('id', 'name')
            ->whereNull('parent_id')->get();
    }

    public function getRootCategoriesExcept(int $exceptId): Collection
    {
        return Category::where('id', '!=', $exceptId)
            ->whereNull('parent_id')
            ->get();
    }

    public function getSubCategories(): Collection
    {
        return Category::query()->select('id', 'name')
            ->whereNotNull('parent_id')
            ->get();
    }

}
