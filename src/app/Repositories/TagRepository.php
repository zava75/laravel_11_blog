<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository
{
    public function all(): Collection
    {
        return Tag::query()->get();
    }
}
