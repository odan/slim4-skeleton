<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserDeleterRepository;

/**
 * Service.
 */
final class UserDeleter
{
    private UserDeleterRepository $repository;

    /**
     * The constructor.
     *
     * @param UserDeleterRepository $repository The repository
     */
    public function __construct(UserDeleterRepository $repository)
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
