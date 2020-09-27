<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserReaderData;
use App\Domain\User\Repository\UserViewerRepository;

/**
 * Service.
 */
final class UserReader
{
    /**
     * @var UserViewerRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserViewerRepository $repository The repository
     */
    public function __construct(UserViewerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user.
     *
     * @param int $userId The user id
     *
     * @return UserReaderData The user data
     */
    public function getUserViewData(int $userId): UserReaderData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $userRow = $this->repository->getUserById($userId);

        // Add or invoke your complex business logic here
        $user = new UserReaderData();
        $user->id = (int)$userRow['id'];
        $user->username = (string)$userRow['username'];
        $user->email = (string)$userRow['email'];

        return $user;
    }
}
