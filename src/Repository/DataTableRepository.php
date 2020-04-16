<?php

namespace App\Repository;

use App\Factory\QueryFactory;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;
use Cake\Database\StatementInterface;
use DomainException;
use RuntimeException;

/**
 * Repository.
 */
class DataTableRepository implements RepositoryInterface
{
    /**
     * @var QueryFactory
     */
    private $queryFactory;

    /**
     * Constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Load data table items.
     *
     * @param Query $query The query
     * @param array $params The parameters
     *
     * @return mixed[] The table data
     */
    public function load(Query $query, array $params): array
    {
        $query = $this->buildQuery($query, $params);

        $countQuery = clone $query;
        $countQuery->select(['count' => $countQuery->func()->count('*')], true);
        $countRows = $countQuery->execute()->fetchAll('assoc') ?: [];

        $count = 0;
        foreach ($countRows as $countRow) {
            $count += $countRow['count'] ?: 0;
        }

        $draw = (int)($params['draw'] ?? 1);
        $offset = (int)($params['start'] ?? 0);
        $limit = (int)($params['length'] ?? 10);
        $offset = max($offset, 0);

        $query->offset($offset);
        $query->limit($limit);

        return [
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'draw' => $draw,
            'data' => $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_ASSOC),
        ];
    }

    /**
     * Returns datatable filter as query array.
     *
     * https://datatables.net/manual/server-side
     *
     * @param Query $query The query
     * @param array $params The search parameters
     *
     * @return Query The query
     */
    private function buildQuery(Query $query, array $params): Query
    {
        $order = (array)($params['order'] ?? []);
        $searchValue = trim($params['search']['value'] ?? '');
        $columns = (array)($params['columns'] ?? []);
        $table = (string)$query->clause('from')[0];
        $fields = $this->getTableFields($table);

        $this->addSearchConditions($query, $table, $columns, $fields, $searchValue);
        $this->addOrderClause($query, $table, $columns, $fields, $order);

        return $query;
    }

    /**
     * Add search conditions.
     *
     * @param Query $query The query
     * @param string $table The table name
     * @param array $columns The columns
     * @param array $fields The table fields
     * @param string $searchValue The order items
     *
     * @return void
     */
    private function addSearchConditions(
        Query $query,
        string $table,
        array $columns,
        array $fields,
        string $searchValue
    ): void {
        if ($searchValue === '') {
            return;
        }

        $orConditions = [];
        $searchValue = $this->escapeLike($searchValue);

        foreach ($columns as $columnItem) {
            $searchField = (string)$columnItem['data'];

            if ($searchField === '' || empty($columnItem['searchable'])) {
                continue;
            }

            $searchField = $this->getFieldName($table, $searchField, $fields);
            $orConditions[$searchField . ' LIKE'] = '%' . $searchValue . '%';
        }

        $query->andWhere(function (QueryExpression $exp) use ($orConditions) {
            return $exp->or_($orConditions);
        });
    }

    /**
     * Add order clause to the query.
     *
     * @param Query $query The query
     * @param string $table The table name
     * @param array $columns The columns
     * @param array $fields The table fields
     * @param array $order The order items
     *
     * @return void
     */
    private function addOrderClause(Query $query, string $table, array $columns, array $fields, array $order): void
    {
        if (empty($order)) {
            return;
        }

        foreach ($order as $orderItem) {
            $columnIndex = $orderItem['column'];
            $columnName = $columns[$columnIndex]['data'];
            $columnName = $this->getFieldName($table, $columnName, $fields);
            $dir = $orderItem['dir'];

            if ($dir === 'asc') {
                $query->order($columnName);
            }
            if ($dir === 'desc') {
                $query->orderDesc($columnName);
            }
        }
    }

    /**
     * Escape like string.
     *
     * @param string $value The string to escape for a like query
     *
     * @return string The escaped string
     */
    private function escapeLike(string $value): string
    {
        return str_replace(['%', '_'], ['\%', '\_'], $value);
    }

    /**
     * Get query field name.
     *
     * @param string $table The table name
     * @param string $field The field name
     * @param array $fields The table fields
     *
     * @return string The full field name
     */
    private function getFieldName(string $table, string $field, array $fields): string
    {
        if (isset($fields[$field]) && strpos($field, '.') === false) {
            $field = sprintf('%s.%s', $table, $field);
        }

        return $field;
    }

    /**
     * Get table fields.
     *
     * @param string $table The table name
     *
     * @throws RuntimeException
     *
     * @return mixed[] The fields
     */
    private function getTableFields(string $table): array
    {
        $query = $this->queryFactory->newSelect('information_schema.columns');
        $query->select(['column_name', 'data_type', 'character_maximum_length']);
        $query->andWhere([
            'table_schema' => $query->newExpr('DATABASE()'),
            'table_name' => $table,
        ]);

        $rows = $query->execute()->fetchAll(StatementInterface::FETCH_TYPE_ASSOC);
        if (empty($rows)) {
            throw new DomainException(__('Columns not found in table: %s', $table));
        }

        $result = [];
        foreach ($rows as $row) {
            $row = array_change_key_case($row);
            $result[$row['column_name']] = $row;
        }

        return $result;
    }
}
