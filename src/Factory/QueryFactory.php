<?php

namespace App\Factory;

use Cake\Database\Connection;
use Cake\Database\Query;
use RuntimeException;
use UnexpectedValueException;

/**
 * Factory.
 */
final class QueryFactory
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var callable
     */
    private $beforeUpdateCallback;

    /**
     * @var callable
     */
    private $beforeInsertCallback;

    /**
     * Constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a new query.
     *
     * @return Query The query
     */
    public function newQuery(): Query
    {
        return $this->connection->newQuery();
    }

    /**
     * Create a new 'select' query for the given table.
     *
     * @param string $table The table name
     *
     * @throws RuntimeException
     *
     * @return Query A new select query
     */
    public function newSelect(string $table): Query
    {
        $query = $this->newQuery()->from($table);

        if (!$query instanceof Query) {
            throw new UnexpectedValueException('Failed to create query');
        }

        return $query;
    }

    /**
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array $data The values to be updated
     *
     * @return Query The new update query
     */
    public function newUpdate(string $table, array $data): Query
    {
        if (isset($this->beforeUpdateCallback)) {
            $data = (array)call_user_func($this->beforeUpdateCallback, $data, $table);
        }

        return $this->newQuery()->update($table)->set($data);
    }

    /**
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array $data The values to be updated
     *
     * @return Query The new insert query
     */
    public function newInsert(string $table, array $data): Query
    {
        if (isset($this->beforeInsertCallback)) {
            $data = (array)call_user_func($this->beforeInsertCallback, $data, $table);
        }

        return $this->newQuery()->insert(array_keys($data))
            ->into($table)
            ->values($data);
    }

    /**
     * Create a 'delete' query for the given table.
     *
     * @param string $table The table to delete from
     *
     * @return Query A new delete query
     */
    public function newDelete(string $table): Query
    {
        return $this->newQuery()->delete($table);
    }

    /**
     * Before update event.
     *
     * @param callable $callback The callback (string $row, string $table)
     *
     * @return void
     */
    public function beforeUpdate(callable $callback): void
    {
        $this->beforeUpdateCallback = $callback;
    }

    /**
     * Before insert event.
     *
     * @param callable $callback The callback (string $row, string $table)
     *
     * @return void
     */
    public function beforeInsert(callable $callback): void
    {
        $this->beforeInsertCallback = $callback;
    }
}
