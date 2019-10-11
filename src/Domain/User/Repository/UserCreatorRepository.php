<?php

namespace App\Domain\User\Repository;

use App\Domain\Repository\QueryFactory;
use App\Domain\Repository\RepositoryInterface;
use App\Domain\User\Data\UserData;

/**
 * Repository.
 */
class UserCreatorRepository implements RepositoryInterface
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
     * @param UserData $user The user
     *
     * @return int The new ID
     */
    public function insertUser(UserData $user): int
    {
        $row = [
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
        ];

        // Insert record into table
        return (int)$this->queryFactory->newInsert('users', $row)->execute()->lastInsertId();
    }
}
