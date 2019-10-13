<?php

namespace App\Domain\User\Mapper;

use App\Domain\User\Data\UserData;

/**
 * Mapper.
 */
final class UserMapper
{
    /**
     * Create data object from array.
     *
     * @param array $data The array with data
     *
     * @return UserData The object
     */
    public static function fromArray(array $data): UserData
    {
        $user = new UserData();

        $user->id = $data['id'] ?? null;
        $user->username = $data['username'] ?? null;
        $user->firstName = $data['first_name'] ?? null;
        $user->lastName = $data['last_name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->locale = $data['locale'] ?? null;
        $user->role = $data['role'] ?? null;
        $user->enabled = (bool)$data['enabled'];

        return $user;
    }
}
