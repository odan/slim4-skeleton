<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;
use App\Repository\RepositoryInterface;
use App\Repository\TableName;
use Cake\Chronos\Chronos;

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

        return (int)$this->queryFactory->newInsert(TableName::USERS, $row)->execute()->lastInsertId();
    }
}
