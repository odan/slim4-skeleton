<?php

namespace App\Domain\User;

use App\Domain\Service\DomainServiceInterface;
use App\Domain\User\Repository\UserRepository;

/**
 * Service.
 */
final class UserDataTable implements DomainServiceInterface
{
    /**
     * @var UserRepository
     */
    private $repository;

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
     * Get data table object.
     *
     * @param array $params The parameters
     *
     * @return array The result
     */
    public function getDataTable(array $params): array
    {
        $draw = (int)($params['draw'] ?? 1);

        return [
            'recordsTotal' => 1,
            'recordsFiltered' => 1,
            'draw' => $draw,
            'data' => $this->repository->findAllUsers(),
        ];
    }
}
