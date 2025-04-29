<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository
{

    public function all(): LengthAwarePaginator
    {
        return Post::query()->select('id', 'name', 'slug', 'image', 'user_id', 'category_id', 'is_active', 'title', 'description')
            ->with(['category.parent', 'user', 'tags:name'])
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function getInactivePosts(): LengthAwarePaginator
    {
        return Post::query()->select('id', 'name', 'slug', 'image', 'user_id', 'category_id', 'is_active', 'title', 'description')
            ->with(['category.parent', 'user', 'tags:name'])
            ->where('is_active', false)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function getByCategoryWithChildren(Category $category): LengthAwarePaginator
    {
        $categoryIds = [$category->id];
        $childIds = $category->children->where('is_active', true)->pluck('id')->toArray();
        $categoryIds = array_merge($categoryIds, $childIds);

        return Post::query()
            ->select('id','name', 'slug', 'description', 'image', 'user_id', 'category_id', 'created_at', 'updated_at')
            ->with(['category.parent:id,name,slug,parent_id', 'user', 'tags:name'])
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', '1');
            })
            ->whereHas('category.parent', function ($query) {
                $query->where('is_active', '1');
            })
            ->latest()
            ->paginate(20);
    }

    public function findBySlug(string $slug): Post
    {
        return Post::query()
            ->where('slug', $slug)
            ->with(['category:id,name,slug,parent_id', 'category.parent:id,name,slug,parent_id','user:id,name','tags:name'])
            ->where('is_active', '1')
            ->where('is_active', '1')
            ->whereHas('category', function ($query) {
                $query->where('is_active', '1');
            })
            ->whereHas('category.parent', function ($query) {
                $query->where('is_active', '1');
            })
            ->firstOrFail();
    }

    public function getRandomByCategory(int $categoryId, int $excludePostId):Collection
    {
        return Post::query()
            ->select('id','name', 'slug', 'description', 'image', 'user_id', 'category_id', 'created_at', 'updated_at')
            ->where('category_id', $categoryId)
            ->where('id', '!=', $excludePostId)
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', '1');
            })
            ->whereHas('category.parent', function ($query) {
                $query->where('is_active', '1');
            })
            ->with(['category.parent:id,slug,name', 'user:id,name','tags:name'])
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }
    public function getLatestPosts(): LengthAwarePaginator
    {
        return Post::query()
            ->select('id','name', 'slug', 'description', 'image', 'user_id', 'category_id', 'created_at', 'updated_at')
            ->with(['category.parent:id,slug,name', 'user:id,name','tags:name'])
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true)
                    ->whereHas('parent', function ($q) {
                        $q->where('is_active', true);
                    });
            })
            ->latest()
            ->paginate(10);
    }

    public function search(string $search):LengthAwarePaginator
    {
        return Post::query()
            ->select('id','name', 'slug', 'description', 'image', 'user_id', 'category_id', 'created_at', 'updated_at')
            ->where('is_active', true)
            ->where('name', 'like', '%' . $search . '%')
            ->with(['category.parent:id,slug,name', 'user:id,name','tags:name'])
            ->whereHas('category', function ($query) {
                $query->where('is_active', true)
                    ->whereHas('parent', function ($q) {
                        $q->where('is_active', true);
                    });
            })
            ->latest()
            ->paginate(10);
    }

    public function getLatestPostsLimit(): Collection
    {
        return Post::query()
            ->with('category.parent')
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', '1');
            })
            ->whereHas('category.parent', function ($query) {
                $query->where('is_active', '1');
            })
            ->latest()
            ->limit(3)->get(['name', 'slug', 'category_id']);
    }

    public function create(array $data): ?Post
    {
        return Post::query()->create($data);
    }

    public function update(int $id, array $data): ?Post
    {
        $post = Post::query()->find($id);

        if ($post->update($data)) {
            return $post;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $post = Post::query()->findOrFail($id);

        return $post->delete();
    }

    public function activate(int $id): bool
    {
        $post = Post::query()->findOrFail($id);
        $post->is_active = true;

        return $post->save();
    }

    public function deactivate(int $id): bool
    {
        $post = Post::query()->findOrFail($id);
        $post->is_active = false;

        return $post->save();
    }

    public function find(int $id): ?Post
    {
        return Post::query()->findOrFail($id);
    }

    public function allPostsUser(): LengthAwarePaginator
    {
        return Post::query()->select('id', 'name', 'slug', 'image', 'user_id', 'category_id', 'is_active', 'title', 'description')
            ->with(['category.parent:id,slug,name','tags:name'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function totalPosts(): int
    {
        return Post::query()->count();
    }

    public function totalPostsNoActive(): int
    {
        return Post::query()
            ->where('is_active', false)
            ->count();
    }

    public function totalPostsActive(): int
    {
        return Post::query()
            ->where('is_active', true)
            ->count();
    }

    public function attachTags(Post $post, array $tags): void
    {
        $post->tags()->sync($tags);
    }

}
