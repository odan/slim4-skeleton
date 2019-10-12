<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Repository\QueryFactory;
use App\Repository\RepositoryInterface;
use Cake\Database\StatementInterface;

/**
 * Repository.
 */
final class UserRepository implements RepositoryInterface
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
     * Find all users.
     *
     * @return UserData[] A list of users
     */
    public function findAllUsers(): array
    {
        $query = $this->queryFactory->newSelect('users')->select('*');

        $rows = $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $result[] = UserData::fromArray($row);
        }

        return $result;
    }
}
