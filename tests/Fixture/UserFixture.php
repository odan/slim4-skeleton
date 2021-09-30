<?php

namespace App\Test\Fixture;

use App\Domain\User\Type\UserRoleType;

/**
 * Fixture.
 */
class UserFixture
{
    public string $table = 'users';

    public array $records = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => '$2y$10$8SCHkI4JUKJ2NA353BTHW.Kgi33HI.2C35xd/j5YUzBx05F1O4lJO',
            'email' => 'admin@example.com',
            'first_name' => null,
            'last_name' => null,
            'user_role_id' => UserRoleType::ROLE_ADMIN,
            'locale' => 'en_US',
            'enabled' => 1,
        ],
        [
            'id' => 2,
            'username' => 'user',
            'password' => '$1$X64.UA0.$kCSxRsj3GKk7Bwy3P6xn1.',
            'email' => 'user@example.com',
            'first_name' => null,
            'last_name' => null,
            'user_role_id' => UserRoleType::ROLE_USER,
            'locale' => 'de_DE',
            'enabled' => 1,
        ],
    ];
}
