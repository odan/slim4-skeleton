<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserFinderRepository;

/**
 * Service.
 */
final class UserFinder
{
    private UserFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param UserFinderRepository $repository The repository
     */
    public function __construct(UserFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find users.
     *
     * @return UserData[] A list of users
     */
    public function findUsers(): array
    {
        // Input validation
        // ...

        return $this->repository->findUsers();
    }
}
