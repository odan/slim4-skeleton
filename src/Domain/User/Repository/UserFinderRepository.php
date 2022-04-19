<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class UserFinderRepository
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
     * Find users.
     *
     * @return UserData[] A list of users
     */
    public function findUsers(): array
    {
        $query = $this->queryFactory->newSelect('users');

        $query->select(
            [
                'id',
                'username',
                'first_name',
                'last_name',
                'email',
                'user_role_id',
                'locale',
                'enabled',
            ]
        );

        // Add more "use case specific" conditions to the query
        // ...

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        // Convert to list of objects
        $result = [];
        foreach ($rows as $row) {
            $result[] = new UserData($row);
        }

        return $result;
    }
}
