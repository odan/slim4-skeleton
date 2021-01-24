<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;

/**
 * Service.
 */
final class UserReader
{
    /**
     * @var UserReaderRepository
     */
    private $repository;

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
     * @return array The user data
     */
    public function getUserData(int $userId): array
    {
        // Input validation
        // ...

        // Fetch data from the database
        $userRow = $this->repository->getUserById($userId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $userRow;
    }
}
