<?php

use Phinx\Seed\AbstractSeed;

class DataSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'id'    => '1',
                'username' => 'admin',
                'password' => '$2y$10$8SCHkI4JUKJ2NA353BTHW.Kgi33HI.2C35xd/j5YUzBx05F1O4lJO',
                'email' => 'admin@example.com',
                'role' => 'ROLE_ADMIN',
                'locale' => 'en_US',
                'enabled' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],[
                'id'    => '2',
                'username' => 'user',
                'password' => '$1$X64.UA0.$kCSxRsj3GKk7Bwy3P6xn1.',
                'email' => 'user@example.com',
                'role' => 'ROLE_USER',
                'locale' => 'de_DE',
                'enabled' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $usersTable = $this->table('users');
        $usersTable->insert($data)->save();
    }
}
