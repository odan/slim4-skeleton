<?php

use App\Domain\User\Type\UserRoleType;
use Cake\Chronos\Chronos;
use Phinx\Migration\AbstractMigration;

/**
 * Fixtures
 */
class AddUserFixtures extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up(): void
    {
        $rows = [];

        $rows[] = [
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'first_name' => 'Admin',
            'last_name' => '',
            'email' => 'admin@example.com',
            'user_role_id' => UserRoleType::ROLE_ADMIN,
            'locale' => 'en_US',
            'enabled' => 1,
            'created_at' => Chronos::now()->toDateTimeString(),
        ];

        $rows[] = [
            'id' => 2,
            'username' => 'user',
            'password' => password_hash('user', PASSWORD_DEFAULT),
            'first_name' => 'User',
            'last_name' => '',
            'email' => 'user@example.com',
            'user_role_id' => UserRoleType::ROLE_USER,
            'locale' => 'de_DE',
            'enabled' => 1,
            'created_at' => Chronos::now()->toDateTimeString(),
        ];

        $this->table('users')->insert($rows)->save();
    }
}
