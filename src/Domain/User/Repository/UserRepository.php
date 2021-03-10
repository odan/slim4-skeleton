<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;
use DomainException;

/**
 * Repository.
 */
final class UserRepository
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
     * Insert user row.
     *
     * @param UserData $user The user data
     *
     * @return int The new ID
     */
    public function insertUser(UserData $user): int
    {
        $row = $this->toRow($user);
        $row['created_at'] = Chronos::now()->toDateTimeString();

        return (int)$this->queryFactory->newInsert('users', $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get user by id.
     *
     * @param int $userId The user id
     *
     * @throws DomainException
     *
     * @return UserData The user
     */
    public function getUserById(int $userId): UserData
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

        $query->andWhere(['id' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }

        return new UserData($row);
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
        $row = $this->toRow($user);

        // Updating the password is another use case
        unset($row['password']);

        $row['updated_at'] = Chronos::now()->toDateTimeString();

        $this->queryFactory->newUpdate('users', $row)
            ->andWhere(['id' => $user->id])
            ->execute();
    }

    /**
     * Check user id.
     *
     * @param int $userId The user id
     *
     * @return bool True if exists
     */
    public function existsUserId(int $userId): bool
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select('id')->andWhere(['id' => $userId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete user row.
     *
     * @param int $userId The user id
     *
     * @return void
     */
    public function deleteUserById(int $userId): void
    {
        $this->queryFactory->newDelete('users')
            ->andWhere(['id' => $userId])
            ->execute();
    }

    /**
     * Convert to array.
     *
     * @param UserData $user The user data
     *
     * @return array The array
     */
    private function toRow(UserData $user): array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'password' => $user->password,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
            'user_role_id' => $user->userRoleId,
            'locale' => $user->locale,
            'enabled' => (int)$user->enabled,
        ];
    }
}
