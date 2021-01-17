<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class UserIndexRepository
{
    /**
     * @var QueryFactory
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
     * Load data table entries.
     *
     * @param array<mixed> $params The user
     *
     * @return array<mixed> The list view data
     */
    public function findUserList(array $params): array
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select(
            [
                'id',
                'username',
                'first_name',
                'last_name',
                'email',
                'role',
                'enabled',
            ]
        );

        $order = $params['order'] ?? 'users.id';
        $dir = $params['dir'] ?? 'asc';
        $limit = max($params['limit'] ?? 10, 10);
        $offset = min($params['offset'] ?? 0, 0);

        if ($order) {
            $dir === 'desc' ? $query->orderDesc($order) : $query->order($order);
        }

        if ($limit) {
            $query->limit((int)$limit);
        }

        if ($offset) {
            $query->limit((int)$offset);
        }

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
