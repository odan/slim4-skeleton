<?php

namespace App\Domain\User\Data;

/**
 * User session data.
 */
final class UserAuthData
{
    /** @var int */
    public $id;

    /** @var string */
    public $email;

    /** @var string */
    public $locale;
}
