<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function all(): LengthAwarePaginator
    {
        return User::query()->select('id',
            'name',
            'email',
            'email_verified_at',
            'is_active',
            'created_at',
            'updated_at')
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function getInactiveUsers(): LengthAwarePaginator
    {
        return User::query()->select('id',
            'name',
            'email',
            'email_verified_at',
            'is_active',
            'created_at',
            'updated_at')
            ->where('is_active', false)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function delete(int $id): bool
    {
        $post = User::query()->findOrFail($id);

        return $post->delete();
    }

    public function activate(int $id): bool
    {
        $post = User::query()->findOrFail($id);
        $post->is_active = true;

        return $post->save();
    }

    public function deActivate(int $id): bool
    {
        $post = User::query()->findOrFail($id);
        $post->is_active = false;

        return $post->save();
    }

    public function find(int $id): ?User
    {
        return User::query()->findOrFail($id);
    }

    public function totalUsers(): int
    {
        return User::query()->count();
    }

    public function totalUsersNoActive(): int
    {
        return User::query()
            ->where('is_active', false)
            ->count();
    }
    public function totalUsersActive(): int
    {
        return User::query()
            ->where('is_active', true)
            ->count();
    }

}
