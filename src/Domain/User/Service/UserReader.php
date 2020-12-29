<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserReaderData;
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
     * @return UserReaderData The user data
     */
    public function getUserData(int $userId): UserReaderData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $userRow = $this->repository->getUserById($userId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Transform the result into a DTO.
        // You can also simply return a primitive type.
        $user = new UserReaderData();
        $user->id = (int)$userRow['id'];
        $user->username = (string)$userRow['username'];
        $user->email = (string)$userRow['email'];

        return $user;
    }
}
