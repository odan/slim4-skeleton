<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserFinderRepository;

/**
 * Service.
 */
final class UserFinder
{
    /**
     * @var UserFinderRepository
     */
    private $repository;

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
     * @param array<mixed> $params The parameters
     *
     * @return array<mixed> The result
     */
    public function findUsers(array $params): array
    {
        return $this->repository->findUsers($params);
    }
}
