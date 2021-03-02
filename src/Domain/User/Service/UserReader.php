<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserReaderRepository;

/**
 * Service.
 */
final class UserReader
{
    private UserReaderRepository $repository;

    /**
     * The constructor.
     *
     * @param UserReaderRepository $repository The repository
     */
    public function __construct(UserReaderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user.
     *
     * @param int $userId The user id
     *
     * @return UserData The user data
     */
    public function getUserData(int $userId): UserData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $user = $this->repository->getUserById($userId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $user;
    }
}
