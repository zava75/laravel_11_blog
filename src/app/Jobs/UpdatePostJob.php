<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\PostRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Bus\Queueable as BusQueueable;

class UpdatePostJob implements ShouldQueue
{
    use Queueable, BusQueueable;

    protected array $data;
    protected array $tags;
    protected int $postId;

    public function __construct(int $postId, array $data, array $tags)
    {
        $this->data = $data;
        $this->tags = $tags;
        $this->postId = $postId;
    }

    public function handle(PostRepository $postRepository)
    {
        $post = $postRepository->update($this->postId, $this->data);

        if ($post && !empty($this->tags)) {
            $post->tags()->sync($this->tags);
        }
    }
}
