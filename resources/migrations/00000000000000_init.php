<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    /**
     * Change.
     *
     * @return void
     */
    public function up(): void
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8mb4';");
        $this->execute("ALTER DATABASE COLLATE='utf8mb4_unicode_ci';");
        $this->table('users', [
            'id' => false,
            'primary_key' => ['id'],
            'engine' => 'InnoDB',
            'encoding' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'comment' => '',
            'row_format' => 'DYNAMIC',
        ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('username', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('password', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'username',
            ])
            ->addColumn('email', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'password',
            ])
            ->addColumn('first_name', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'email',
            ])
            ->addColumn('last_name', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'first_name',
            ])
            ->addColumn('user_role_id', 'integer', [
                'null' => true,
                'default' => '2',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'last_name',
            ])
            ->addColumn('locale', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_ci',
                'encoding' => 'utf8mb4',
                'after' => 'user_role_id',
            ])
            ->addColumn('enabled', 'boolean', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'locale',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => true,
                'after' => 'enabled',
            ])
            ->addColumn('created_user_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'created_at',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_user_id',
            ])
            ->addColumn('updated_user_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'updated_at',
            ])
            ->addIndex(['username'], [
                'name' => 'username',
                'unique' => true,
            ])
            ->addIndex(['created_user_id'], [
                'name' => 'created_user_id',
                'unique' => false,
            ])
            ->addIndex(['updated_user_id'], [
                'name' => 'updated_user_id',
                'unique' => false,
            ])
            ->addIndex(['user_role_id'], [
                'name' => 'user_role_id',
                'unique' => false,
            ])
            ->create();
    }
}
