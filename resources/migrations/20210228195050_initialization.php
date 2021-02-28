<?php

use Phoenix\Migration\AbstractMigration;

class Initialization extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('users', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_unicode_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('username', 'string', ['null' => true])
            ->addColumn('password', 'string', ['null' => true])
            ->addColumn('email', 'string', ['null' => true])
            ->addColumn('first_name', 'string', ['null' => true])
            ->addColumn('last_name', 'string', ['null' => true])
            ->addColumn('user_role_id', 'integer', ['null' => true, 'default' => 2])
            ->addColumn('locale', 'string', ['null' => true])
            ->addColumn('enabled', 'boolean', ['default' => false])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('created_user_id', 'integer', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('updated_user_id', 'integer', ['null' => true])
            ->addIndex('created_user_id', '', 'btree', 'created_user_id')
            ->addIndex('updated_user_id', '', 'btree', 'updated_user_id')
            ->addIndex('user_role_id', '', 'btree', 'user_role_id')
            ->addIndex('username', 'unique', 'btree', 'username')
            ->create();
    }

    protected function down(): void
    {
        $this->table('users')
            ->drop();
    }
}
