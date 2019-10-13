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
}
