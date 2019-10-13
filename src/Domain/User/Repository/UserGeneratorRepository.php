<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Repository\QueryFactory;
use App\Repository\RepositoryInterface;
use App\Repository\TableName;

/**
 * Repository.
 */
class UserGeneratorRepository implements RepositoryInterface
{
    /**
     * @var QueryFactory The query factory
     */
    private $queryFactory;

    /**
     * Constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Insert user row.
     *
     * @param User $user The user
     *
     * @return int The new ID
     */
    public function insertUser(User $user): int
    {
        $row = [
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
        ];

        return (int)$this->queryFactory->newInsert(TableName::USERS, $row)->execute()->lastInsertId();
    }
}
