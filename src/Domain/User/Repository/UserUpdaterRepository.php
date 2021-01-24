<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;

/**
 * Repository.
 */
final class UserUpdaterRepository
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
     * Update user row.
     *
     * @param int $userId The user id
     * @param array<mixed> $data The user data
     *
     * @return void
     */
    public function updateUser(int $userId, array $data): void
    {
        $data['updated_at'] = Chronos::now()->toDateTimeString();

        $this->queryFactory->newUpdate('users', $data)->andWhere(['id' => $userId])->execute();
    }
}
