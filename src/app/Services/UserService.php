<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function all():LengthAwarePaginator
    {
        return $this->userRepository->all();
    }

    public function getInactiveUsers():LengthAwarePaginator
    {
        return $this->userRepository->getInactiveUsers();
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);

    }

    public function delete(int $id): bool
    {
       return $this->userRepository->delete($id);
    }

    public function activate(int $id): bool
    {
        return $this->userRepository->activate($id);
    }

    public function deActivate(int $id): bool
    {
        return $this->userRepository->deActivate($id);
    }

    public function totalUsers(): int
    {
        return $this->userRepository->totalUsers();
    }

    public function totalUsersNoActive(): int
    {
        return $this->userRepository->totalUsersNoActive();
    }
    public function totalUsersActive(): int
    {
        return $this->userRepository->totalUsersActive();
    }
}
