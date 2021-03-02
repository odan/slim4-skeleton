<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;

/**
 * Repository.
 */
final class UserUpdaterRepository
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
     * Update user row.
     *
     * @param UserData $user The user
     *
     * @return void
     */
    public function updateUser(UserData $user): void
    {
        $row = $user->toArray();

        // Updating the password is another use case
        unset($row['password']);

        $row['updated_at'] = Chronos::now()->toDateTimeString();

        $this->queryFactory->newUpdate('users', $row)->andWhere(['id' => $user->id])->execute();
    }
}
