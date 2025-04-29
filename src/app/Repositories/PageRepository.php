<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PageRepository
{

    public function all(): LengthAwarePaginator
    {
        return Page::query()
        ->select('id', 'name', 'slug', 'article', 'title', 'description','h1')->paginate(20);
    }

    public function update(array $data, int $id): int|bool
    {
        $user = Page::query()->findOrFail($id);

        return $user->update($data);
    }

    public function findBySlug(string $slug): ?Page
    {
        return Page::query()->where('slug', $slug)->first();
    }

}
