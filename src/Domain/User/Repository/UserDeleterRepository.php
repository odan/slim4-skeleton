<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class UserDeleterRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Delete user row.
     *
     * @param int $userId The user id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteUserById(int $userId): void
    {
        $statement = $this->queryFactory->newDelete('users')->andWhere(['id' => $userId])->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete user: %s', $userId));
        }
    }
}
