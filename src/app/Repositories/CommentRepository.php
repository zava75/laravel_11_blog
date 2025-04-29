<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CommentRepository
{
    public function all(): LengthAwarePaginator
    {
        return Comment::query()->select('id',
            'post_id',
            'user_id',
            'guest_name',
            'guest_email',
            'content',
            'is_active',
            'created_at',
            'updated_at')
            ->with(['post:id,name,slug,category_id','user:id,name'])
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function getInactiveComments(): LengthAwarePaginator
    {
        return Comment::query()->select('id',
            'post_id',
            'user_id',
            'guest_name',
            'guest_email',
            'content',
            'is_active',
            'created_at',
            'updated_at')
            ->with(['post:id,name,slug,category_id','user:id,name'])
            ->where('is_active', false)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function create(array $data):bool
    {
        $comment = Comment::query()->create($data);

        return $comment->exists;
    }

    public function delete(int $id): bool
    {
        $post = Comment::query()->findOrFail($id);

        return $post->delete();
    }

    public function activate(int $id): bool
    {
        $post = Comment::query()->findOrFail($id);
        $post->is_active = true;

        return $post->save();
    }

    public function deActivate(int $id): bool
    {
        $post = Comment::query()->findOrFail($id);
        $post->is_active = false;

        return $post->save();
    }

    public function find(int $id): ?Comment
    {
        return Comment::query()->findOrFail($id);
    }

    public function postAllComments(int $postId): Collection
    {
        return Comment::query()->select('guest_name','content','created_at')
            ->where('post_id', $postId)
            ->where('is_active', true)
            ->orderBy('id', 'desc')->get();
    }

    public function totalComments(): int
    {
        return Comment::query()->count();
    }

    public function totalCommentsNoActive(): int
    {
        return Comment::query()
            ->where('is_active', false)
            ->count();
    }
    public function totalCommentsActive(): int
    {
        return Comment::query()
            ->where('is_active', true)
            ->count();
    }

}
