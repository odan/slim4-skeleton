<?php

namespace App\Test;

use PDO;
use UnexpectedValueException;

/**
 * Database test.
 */
trait DatabaseTestTrait
{
    use AppTestTrait;

    /**
     * Create tables and insert fixtures.
     *
     * @before
     *
     * @return void
     */
    protected function setupDatabase(): void
    {
        $this->getConnection();

        $this->createTables();
        $this->truncateTables();

        if (!empty($this->fixtures)) {
            $this->insertFixtures($this->fixtures);
        }
    }

    /**
     * Get database connection.
     *
     * @return PDO The PDO instance
     */
    protected function getConnection(): PDO
    {
        return $this->container->get(PDO::class);
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
        $pdo = $this->getConnection();
        $pdo->exec('SET unique_checks=0; SET foreign_key_checks=0;');
        $pdo->exec((string)file_get_contents(__DIR__ . '/../resources/migrations/schema.sql'));
        $pdo->exec('SET unique_checks=1; SET foreign_key_checks=1;');
    }

    /**
     * Clean up database. Truncate tables.
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    protected function dropTables(): void
    {
        $pdo = $this->getConnection();

        $pdo->exec('SET unique_checks=0; SET foreign_key_checks=0;');

        $statement = $pdo->query('SELECT TABLE_NAME
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
            $pdo->exec(implode("\n", $sql));
        }

        $pdo->exec('SET unique_checks=1; SET foreign_key_checks=1;');
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
        $pdo = $this->getConnection();

        $pdo->exec('SET unique_checks=0; SET foreign_key_checks=0; SET information_schema_stats_expiry=0');

        // Truncate only changed tables
        $statement = $pdo->query('SELECT TABLE_NAME
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
            $pdo->exec(implode("\n", $sql));
        }

        $pdo->exec('SET unique_checks=1; SET foreign_key_checks=1;');
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
        $pdo = $this->getConnection();

        foreach ($fixtures as $fixture) {
            $object = new $fixture();
            $table = $object->table;

            $fields = array_keys($object->records[0]);
            array_walk($fields, function (&$value) {
                $value = sprintf('`%s`=:%s', $value, $value);
            });
            $statement = $pdo->prepare(sprintf('INSERT INTO `%s` SET %s', $table, implode(',', $fields)));

            foreach ($object->records as $row) {
                $statement->execute($row);
            }
        }
    }
}
