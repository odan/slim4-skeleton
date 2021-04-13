<?php

namespace App\Factory;

use Cake\Database\Connection;
use Cake\Database\Query;
use RuntimeException;

/**
 * Factory.
 */
final class QueryFactory
{
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
        return $this->newQuery()->from($table);
    }

    /**
     * Create a new 'select' query for the given table and add optional conditions.
     *
     * @param string $table The table name
     * @param array $params The query params
     *
     * @return Query A new select query
     */
    public function newSelectWithConditions(string $table, array $params): Query
    {
        $query = $this->newSelect($table);

        $order = $params['order'] ?? 'users.id';
        $dir = $params['dir'] ?? 'asc';
        $limit = max($params['limit'] ?? 10, 10);
        $offset = max($params['offset'] ?? 0, 0);

        if ($order) {
            $dir === 'desc' ? $query->orderDesc($order) : $query->order($order);
        }

        if ($limit) {
            $query->limit((int)$limit);
        }

        $query->offset((int)$offset);

        return $query;
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
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array<mixed> $data The values to be updated
     *
     * @return Query The new update query
     */
    public function newUpdate(string $table, array $data): Query
    {
        return $this->newQuery()->update($table)->set($data);
    }

    /**
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array<mixed> $data The values to be updated
     *
     * @return Query The new insert query
     */
    public function newInsert(string $table, array $data): Query
    {
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
}
