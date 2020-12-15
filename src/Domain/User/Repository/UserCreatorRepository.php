<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;

/**
 * Repository.
 */
final class UserCreatorRepository
{
    /**
     * @var QueryFactory The query factory
     */
    private $queryFactory;

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
     * Insert user row.
     *
     * @param array $row The user data
     *
     * @return int The new ID
     */
    public function insertUser(array $row): int
    {
        $row['created_at'] = Chronos::now()->toDateTimeString();

        return (int)$this->queryFactory->newInsert('users', $row)->execute()->lastInsertId();
    }
}
