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
     * @param array<mixed> $params The user
     *
     * @return UserData[] A list of users
     */
    public function findUsers(array $params): array
    {
        $query = $this->queryFactory->newSelect('users');
        $query = $this->queryFactory->withConditions($query, $params);

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

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        // Convert to list of objects
        return hydrate($rows, UserData::class);
    }
}
