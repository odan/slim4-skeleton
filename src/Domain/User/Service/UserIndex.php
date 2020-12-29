<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserIndexRepository;

/**
 * Service.
 */
final class UserIndex
{
    /**
     * @var UserIndexRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserIndexRepository $repository The repository
     */
    public function __construct(UserIndexRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List users.
     *
     * @param array $params The parameters
     *
     * @return array The result
     */
    public function listUsers(array $params): array
    {
        return $this->repository->findUserList($params);
    }
}
