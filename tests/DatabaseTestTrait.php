<?php

namespace App\Test;

use Cake\Database\Connection;
use PDO;
use UnexpectedValueException;

/**
 * Database test.
 */
trait DatabaseTestTrait
{
    use AppTestTrait {
        setUp as protected setUpApp;
    }

    /** {@inheritdoc} */
    protected function setUp(): void
    {
        $this->setUpApp();
        $this->setUpDatabase();
    }

    /**
     * Create tables and insert fixtures.
     *
     * @return void
     */
    protected function setUpDatabase(): void
    {
        $this->getConnection()->connect();

        $this->createTables();
        $this->truncateTables();

        if (!empty($this->fixtures)) {
            $this->insertFixtures($this->fixtures);
        }
    }

    /**
     * Get database connection.
     *
     * @return Connection The test database connection
     */
    protected function getConnection(): Connection
    {
        return $this->container->get(Connection::class);
    }

    /**
     * Get PDO.
     *
     * @throws UnexpectedValueException
     *
     * @return PDO The PDO instance
     */
    protected function getPdo(): PDO
    {
        $pdo = $this->getConnection()->getDriver()->getConnection();

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        throw new UnexpectedValueException('Database connection failed');
    }

    /**
     * Create tables.
     *
     * @return void
     */
    protected function createTables(): void
    {
        if (defined('DB_TEST_TRAIT_INIT')) {
            return;
        }

        $this->dropTables();
        $this->importSchema();

        define('DB_TEST_TRAIT_INIT', 1);
    }

    /**
     * Import table schema.
     *
     * @return void
     */
    protected function importSchema(): void
    {
        $pdo = $this->getPdo();
        $pdo->exec('SET unique_checks=0; SET foreign_key_checks=0;');
        $pdo->exec((string)file_get_contents(__DIR__ . '/../resources/migrations/schema.sql'));
        $pdo->exec('SET unique_checks=1; SET foreign_key_checks=1;');
    }

    /**
     * Clean-Up Database. Truncate tables.
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function dropTables(): void
    {
        $db = $this->getPdo();

        $db->exec('SET unique_checks=0; SET foreign_key_checks=0;');

        $statement = $db->query('SELECT TABLE_NAME
                FROM information_schema.tables
                WHERE table_schema = database()');

        if (!$statement) {
            throw new UnexpectedValueException('Invalid SQL statement');
        }

        $sql = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sql[] = sprintf('DROP TABLE `%s`;', $row['TABLE_NAME']);
        }

        if ($sql) {
            $db->exec(implode("\n", $sql));
        }

        $db->exec('SET unique_checks=1; SET foreign_key_checks=1;');
    }

    /**
     * Clean up database.
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function truncateTables(): void
    {
        $db = $this->getPdo();

        $db->exec('SET unique_checks=0; SET foreign_key_checks=0; SET information_schema_stats_expiry=0');

        // Truncate only changed tables
        $statement = $db->query('SELECT TABLE_NAME
                FROM information_schema.tables
                WHERE table_schema = database()
                AND update_time IS NOT NULL');

        if (!$statement) {
            throw new UnexpectedValueException('Invalid SQL statement');
        }

        $sql = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sql[] = sprintf('TRUNCATE TABLE `%s`;', $row['TABLE_NAME']);
        }

        if ($sql) {
            $db->exec(implode("\n", $sql));
        }

        $db->exec('SET unique_checks=1; SET foreign_key_checks=1;');
    }

    /**
     * Iterate over all fixtures and insert them into their tables.
     *
     * @param array $fixtures The fixtures
     *
     * @return void
     */
    protected function insertFixtures(array $fixtures): void
    {
        $db = $this->getConnection();

        foreach ($fixtures as $fixture) {
            $object = new $fixture();
            $table = $object->table;

            foreach ($object->records as $row) {
                $db->newQuery()->insert(array_keys($row))->into($table)->values($row)->execute();
            }
        }
    }
}
