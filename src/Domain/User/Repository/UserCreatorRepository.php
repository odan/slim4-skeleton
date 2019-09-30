<?php

namespace App\Domain\User\Repository;

use App\Domain\Repository\RepositoryInterface;

/**
 * Repository.
 */
class UserCreatorRepository implements RepositoryInterface
{
    /**
     * Insert user row.
     *
     * @param array $data The data
     *
     * @return int The new ID
     */
    public function insertUser(array $data): int
    {
        return 1;
    }
}
