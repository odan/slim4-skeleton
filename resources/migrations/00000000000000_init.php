<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Init extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8';");
        $this->execute("ALTER DATABASE COLLATE='utf8_unicode_ci';");
        $this->table('users', [
            'id' => false,
            'primary_key' => ['id'],
            'engine' => 'InnoDB',
            'encoding' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'comment' => '',
            'row_format' => 'DYNAMIC',
        ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'precision' => '10',
                'identity' => 'enable',
            ])
            ->addColumn('username', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'id',
            ])
            ->addColumn('password', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'username',
            ])
            ->addColumn('email', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'password',
            ])
            ->addColumn('first_name', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'email',
            ])
            ->addColumn('last_name', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'first_name',
            ])
            ->addColumn('role', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'last_name',
            ])
            ->addColumn('locale', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8_unicode_ci',
                'encoding' => 'utf8',
                'after' => 'role',
            ])
            ->addColumn('enabled', 'boolean', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'precision' => '3',
                'after' => 'locale',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => true,
                'after' => 'enabled',
            ])
            ->addColumn('created_user_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'precision' => '10',
                'after' => 'created_at',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_user_id',
            ])
            ->addColumn('updated_user_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'precision' => '10',
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
            ->create();
    }
}
