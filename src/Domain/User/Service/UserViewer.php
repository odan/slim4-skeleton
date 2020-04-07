<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserViewData;
use App\Domain\User\Repository\UserViewerRepository;
use App\Interfaces\ServiceInterface;

/**
 * Service.
 */
final class UserViewer implements ServiceInterface
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
     * @return UserViewData The user
     */
    public function getUserViewData(int $userId): UserViewData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $userRow = $this->repository->getUserById($userId);

        // Add or invoke your complex business logic here
        $user = new UserViewData();
        $user->id = (int)$userRow['id'];
        $user->username = (string)$userRow['username'];
        $user->email = (string)$userRow['email'];

        return $user;
    }
}
