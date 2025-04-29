<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\CommentRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Bus\Queueable as BusQueueable;

class CreateCommentJob implements ShouldQueue
{
    use Queueable, BusQueueable;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(CommentRepository $commentRepository)
    {
        return $commentRepository->create($this->data);
    }
}
