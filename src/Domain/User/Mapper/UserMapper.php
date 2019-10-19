<?php

namespace App\Domain\User\Mapper;

use App\Domain\User\Model\User;
use Selective\ArrayReader\ArrayReader;

/**
 * Mapper.
 */
final class UserMapper
{
    /**
     * Map array to model.
     *
     * @param array $array The array with data
     *
     * @return User The object
     */
    public static function createFromArray(array $array): User
    {
        $data = new ArrayReader($array);

        $user = new User();
        $user->id = $data->findInt('id');
        $user->username = $data->findString('username');
        $user->firstName = $data->findString('first_name');
        $user->lastName = $data->findString('last_name');
        $user->email = $data->findString('email');
        $user->locale = $data->findString('locale');
        $user->role = $data->findString('role');
        $user->enabled = $data->getBool('enabled', false);

        return $user;
    }
}
