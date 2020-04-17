<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserCreatorData;
use App\Factory\QueryFactory;
use App\Repository\RepositoryInterface;
use App\Repository\TableName;
use DomainException;

/**
 * Repository.
 */
final class UserViewerRepository implements RepositoryInterface
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
     * Get user by id.
     *
     * @param int $userId The user id
     *
     * @throws DomainException
     *
     * @return array The user row
     */
    public function getUserById(int $userId): array
    {
        $query = $this->queryFactory->newSelect(TableName::USERS);
        $query->select([
            'id',
            'username',
            'email',
        ]);

        $query->andWhere(['id' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(__('User not found: %s', $userId));
        }

        return $row;
    }

    /**
     * Find all users.
     *
     * @return UserCreatorData[] A list of users
     */
    public function findAllUsers(): array
    {
        $query = $this->queryFactory->newSelect(TableName::USERS)->select('*');

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        $result = [];
        foreach ($rows as $row) {
            $result[] = new UserCreatorData($row);
        }

        return $result;
    }
}
