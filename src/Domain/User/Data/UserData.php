<?php

namespace App\Domain\User\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data object.
 */
final class UserData
{
    /** @var int|null */
    public $id;

    /** @var string|null */
    public $username;

    /** @var string|null */
    public $password;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $firstName;

    /** @var string|null */
    public $lastName;

    /** @var string|null */
    public $role;

    /** @var string|null */
    public $locale;

    /** @var bool */
    public $enabled = false;

    /**
     * Named constructor.
     *
     * @param array $array The array with data
     *
     * @return self
     */
    public static function fromArray(array $array = []): self
    {
        $data = new ArrayReader($array);

        $user = new self();
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
