<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\CreatePostJob;
use App\Jobs\UpdatePostJob;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected DataSanitizer $sanitizer;
    protected PostRepository $postRepository;
    public function __construct(PostRepository $postRepository, DataSanitizer $sanitizer){
        $this->postRepository = $postRepository;
        $this->sanitizer = $sanitizer;
    }

    public function all():LengthAwarePaginator
    {
        return $this->postRepository->all();
    }

    public function find(int $id): ?Post
    {
        return $this->postRepository->find($id);

    }

    public function getInactivePosts(): LengthAwarePaginator
    {
        return $this->postRepository->getInactivePosts();
    }

    public function getPostsCategory(Category $category): LengthAwarePaginator
    {
        if (!config('cache.enable')) {
            return $this->postRepository->getByCategoryWithChildren($category);
        }

        $page = (int) request()->query('page', 1);
        $cacheKey = "category_posts_{$category->id}_page_{$page}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () use ($category) {
            return $this->postRepository->getByCategoryWithChildren($category);
        });
    }

    public function getRandomPostsCategory(int $categoryId, int $excludePostId): Collection
    {
        if (!config('cache.enable')) {
            return $this->postRepository->getRandomByCategory($categoryId, $excludePostId);
        }
        $cacheKey = "random_posts_category_{$excludePostId}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')),
               function () use ($categoryId, $excludePostId) {
            return $this->postRepository->getRandomByCategory($categoryId, $excludePostId);
        });
    }

    public function getLatestPosts(): LengthAwarePaginator
    {
        if (!config('cache.enable')) {
            return $this->postRepository->getLatestPosts();
        }
        $page = (int) request()->query('page', 1);
        $cacheKey = "latest_posts_page_{$page}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () {
            return $this->postRepository->getLatestPosts();
        });
    }

    public function getLatestPostsLimit(): Collection
    {
        if (!config('cache.enable')) {
            return $this->postRepository->getLatestPostsLimit();
        }
        return Cache::remember('latest_posts_limit', now()->addMinutes((int) config('cache.add_minutes')), function () {
            return $this->postRepository->getLatestPostsLimit();
        });

    }

    public function search(string $search):LengthAwarePaginator
    {
            return $this->postRepository->search($search);
    }

    public function show(string $slug): Post
    {
        if (!config('cache.enable')) {
            return $this->postRepository->findBySlug($slug);
        }
        $cacheKey = "post_slug_{$slug}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () use ($slug) {

            $post = $this->postRepository->findBySlug($slug);
            $post->load('category:id,name,slug,parent_id,is_active', 'category.parent:id,name,slug,parent_id,is_active');

            return $post;

        });
    }

    public function create(array $data, array $tags):bool
    {
        $data['user_id'] = auth()->id();

        if(!auth()->user()->isAdmin()){
            $data['is_active'] = false;
        }
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('blog', $imageName, 'images');
        }
        $sanitized = $this->sanitizer->sanitize($data);

        try {
            CreatePostJob::dispatch($sanitized, $tags);
        } catch (\Exception $e) {
//            \Log::error("Failed to dispatch CreatePostJob: " . $e->getMessage());
            return false;
        }

        return true;
    }

    public function update(int $id, array $data, array $tags):bool
    {
        $data['user_id'] = auth()->id();

        if(!auth()->user()->isAdmin()){
            $data['is_active'] = false;
        }
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('blog', $imageName, 'images');
        }
        $data = $this->sanitizer->sanitize($data);

        try {
            UpdatePostJob::dispatch($id, $data, $tags);
        } catch (\Exception $e) {
//            \Log::error("Failed to dispatch UpdatePostJob: " . $e->getMessage());
            return false;
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return false;
        }
        if ($post->image
            && Storage::disk('images')->exists($post->image)
            && !str_starts_with($post->image, 'demo/')
        ) {
            Storage::disk('images')->delete($post->image);
        }

        return $post->delete();
    }

    public function activate(int $id): bool
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return false;
        }
        $post->is_active = true;

        return $post->save();
    }

    public function deactivate(int $id): bool
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return false;
        }
        $post->is_active = false;

        return $post->save();
    }

    public function deleteImage(int $id): bool
    {

        $post = $this->postRepository->find($id);
        if (!$post) {
            return false;
        }
        if ($post->image
            && Storage::disk('images')->exists($post->image)
            && !str_starts_with($post->image, 'demo/')
        ) {
            Storage::disk('images')->delete($post->image);
        } else {
            return false;
        }
        $post->image = null;

        return $post->save();
    }

    public function allPostsUser():LengthAwarePaginator
    {
        return $this->postRepository->allPostsUser();
    }

    public function totalPosts(): int
    {
        return $this->postRepository->totalPosts();
    }

      public function totalPostsNoActive(): int
      {
          return $this->postRepository->totalPostsNoActive();
      }
      public function totalPostsActive(): int
      {
          return $this->postRepository->totalPostsActive();
      }

    public function updateTags(Post $post, array $tags): void
    {
        $this->postRepository->attachTags($post, $tags);
    }
}
