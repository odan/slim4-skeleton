<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

/**
 * Service.
 */
final class UserDeleter
{
    private UserRepository $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete user.
     *
     * @param int $userId The user id
     *
     * @return void
     */
    public function deleteUser(int $userId): void
    {
        // Input validation
        // ...

        $this->repository->deleteUserById($userId);
    }
}
