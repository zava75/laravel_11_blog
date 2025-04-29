<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Support\Collection;

class TagService
{
    protected TagRepository $tagRepository;
    public function __construct(TagRepository $tagRepository){

        $this->tagRepository = $tagRepository;
    }

    public function all(): Collection
    {
        return $this->tagRepository->all();
    }

}
