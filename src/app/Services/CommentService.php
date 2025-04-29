<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\CreateCommentJob;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CommentService
{
    protected DataSanitizer $sanitizer;
    protected CommentRepository $commentRepository;
    public function __construct(CommentRepository $commentRepository, DataSanitizer $sanitizer){
        $this->commentRepository = $commentRepository;
        $this->sanitizer = $sanitizer;
    }

    public function all():LengthAwarePaginator
    {
        return $this->commentRepository->all();
    }

    public function getInactiveComments():LengthAwarePaginator
    {
        return $this->commentRepository->getInactiveComments();
    }

    public function find(int $id): ?Comment
    {
        return $this->commentRepository->find($id);

    }

    public function create(array $data): bool
    {
        try {
            CreateCommentJob::dispatch($data);
        } catch (\Exception $e) {
//            \Log::error("Failed to dispatch CreateCommentJob: " . $e->getMessage());
            return false;
        }

        return true;
    }

    public function delete(int $id): bool
    {
       return $this->commentRepository->delete($id);
    }

    public function activate(int $id): bool
    {
        return $this->commentRepository->activate($id);
    }

    public function deActivate(int $id): bool
    {
        return $this->commentRepository->deActivate($id);
    }

    public function postAllComments(int $postId):Collection
    {
        if(!config('cache.enable')){
            return $this->commentRepository->postAllComments($postId);
        }
        $cacheKey = "post_comments_{$postId}";

        return Cache::remember($cacheKey, now()->addMinutes((int) config('cache.add_minutes')), function () use ($postId) {
            return $this->commentRepository->postAllComments($postId);
        });
    }

    public function totalComments(): int
    {
        return $this->commentRepository->totalComments();
    }

    public function totalCommentsNoActive(): int
    {
        return $this->commentRepository->totalCommentsNoActive();
    }
    public function totalCommentsActive(): int
    {
        return $this->commentRepository->totalCommentsActive();
    }

}
