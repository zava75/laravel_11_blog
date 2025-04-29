<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PageService
{

    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function all(): LengthAwarePaginator
    {
        return $this->pageRepository->all();
    }

    public function update(string $slug, array $data): bool
    {
        $page = $this->pageRepository->findBySlug($slug);
        if (!$page) {
            return false;
        }
        return $page->update($data);
    }

    public function findBySlug(string $slug): ?Page
    {
        if (!config('cache.enable')) {
            return $this->pageRepository->findBySlug($slug);
        }
        $cacheKey = "page_slug_{$slug}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () use ($slug) {
            return $this->pageRepository->findBySlug($slug);
        });
    }
}
