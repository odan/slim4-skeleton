<?php

namespace App\Test\TestCase;

use Cake\Database\Connection;
use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use UnexpectedValueException;

/**
 * Integration test.
 */
trait DatabaseTestTrait
{
    use UnitTestTrait;

    /** {@inheritdoc} */
    protected function setUp(): void
    {
        $this->bootApp();

        $this->setUpDatabase();
    }

    /** {@inheritdoc} */
    protected function tearDown(): void
    {
        $this->shutdownApp();
    }

    /**
     * Call this template method before each test method is run.
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
     * Get Connection.
     *
     * @return Connection The test database connection
     */
    public function getConnection(): Connection
    {
        return $this->getContainer()->get(Connection::class);
    }

    /**
     * Get PDO.
     *
     * @throws UnexpectedValueException
     *
     * @return PDO The PDO instance
     */
    public function getPdo(): PDO
    {
        $pdo = $this->getConnection()->getDriver()->getConnection();

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        throw new UnexpectedValueException('Expected value is not PDO');
    }

    /**
     * Create tables.
     *
     * @return bool Success
     */
    public function createTables(): bool
    {
        if (defined('DB_TEST_TRAIT_INIT')) {
            return true;
        }

        $this->dropTables();
        //$this->migrate();
        $this->importSchema();

        define('DB_TEST_TRAIT_INIT', 1);

        return true;
    }

    /**
     * Prepare the database schema with phinx (slow).
     *
     * @return bool Success
     */
    protected function migrate(): bool
    {
        $config = new Config(require __DIR__ . '/../../config/phinx.php');
        $manager = new Manager($config, new StringInput(' '), new NullOutput());
        $manager->migrate('local');
        $manager->seed('local');

        return true;
    }

    /**
     * Import table schema.
     *
     * @return void
     */
    protected function importSchema(): void
    {
        $sql = (string)file_get_contents(__DIR__ . '/../../resources/migrations/schema.sql');

        $pdo = $this->getPdo();
        $pdo->exec('SET unique_checks=0; SET foreign_key_checks=0;');
        $pdo->exec($sql);
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
            throw new UnexpectedValueException('Invalid sql statement');
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
     * Clean-Up Database. Truncate tables.
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
            throw new UnexpectedValueException('Invalid sql statement');
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
     * Iterate over all the fixture rows specified and insert them into their respective tables.
     *
     * @param array $fixtures Fixtures
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
