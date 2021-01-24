<?php

namespace App\Domain\User\Type;

/**
 * Type.
 */
final class UserRoleType
{
    /** @var int[] */
    public const ALL = [self::ROLE_ADMIN, self::ROLE_ADMIN];

    /** @var int */
    public const ROLE_ADMIN = 1;

    /** @var int */
    public const ROLE_USER = 2;
}
