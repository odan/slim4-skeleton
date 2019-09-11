<?php

namespace App\Domain\User;

/**
 * Repository
 */
class UserCreatorRepository
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
