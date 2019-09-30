<?php

namespace App\Domain\User\Repository;

use App\Domain\Repository\RepositoryInterface;

/**
 * Repository.
 */
final class UserRepository implements RepositoryInterface
{
    /**
     * Find all users.
     *
     * @return array The users
     */
    public function findAllUsers(): array
    {
        return [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'first_name' => 'Admin',
                'last_name' => 'Root',
                'role' => 'ROLE_ADMIN',
                'enabled' => true,
                'created_at' => '2019-01-01 00:00:00',
            ],
        ];
    }
}
