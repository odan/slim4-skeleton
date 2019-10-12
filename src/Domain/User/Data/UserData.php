<?php

namespace App\Domain\User\Data;

/**
 * Data.
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
     * Create data object from array.
     *
     * @param array $row The row data
     *
     * @return self The data object
     */
    public static function fromArray(array $row): self
    {
        $user = new self();

        $user->id = $row['id'] ?? null;
        $user->username = $row['username'] ?? null;
        $user->firstName = $row['first_name'] ?? null;
        $user->lastName = $row['last_name'] ?? null;
        $user->email = $row['email'] ?? null;
        $user->locale = $row['locale'] ?? null;
        $user->role = $row['role'] ?? null;
        $user->enabled = (bool)$row['enabled'];

        return $user;
    }
}
