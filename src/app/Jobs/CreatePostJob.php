<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\PostRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Bus\Queueable as BusQueueable;

class CreatePostJob implements ShouldQueue
{
    use Queueable, BusQueueable;

    protected array $data;
    protected array $tags;

    public function __construct(array $data, array $tags)
    {
        $this->data = $data;
        $this->tags = $tags;
    }

    public function handle(PostRepository $postRepository)
    {
        $post = $postRepository->create($this->data);

        if ($post && !empty($this->tags)) {
            $post->tags()->sync($this->tags);
        }
    }
}
