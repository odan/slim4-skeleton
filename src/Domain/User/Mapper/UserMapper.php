<?php

namespace App\Domain\User\Mapper;

use App\Domain\User\Model\User;

/**
 * Mapper.
 */
final class UserMapper
{
    /**
     * Maps array to new.
     *
     * @param array $data The array with data
     *
     * @return User The object
     */
    public static function createFromArray(array $data): User
    {
        $user = new User();
        $user->id = isset($data['id']) ? (int)$data['id'] : null;
        $user->username = isset($data['username']) ? (string)$data['username'] : null;
        $user->firstName = isset($data['first_name']) ? (string)$data['first_name'] : null;
        $user->lastName = isset($data['last_name']) ? (string)$data['last_name'] : null;
        $user->email = isset($data['email']) ? (string)$data['email'] : null;
        $user->locale = isset($data['locale']) ? (string)$data['locale'] : null;
        $user->role = isset($data['role']) ? (string)$data['role'] : null;
        $user->enabled = isset($data['enabled']) ? (bool)$data['enabled'] : false;

        return $user;
    }
}
