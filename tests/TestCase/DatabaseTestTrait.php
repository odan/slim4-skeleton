<?php

namespace App\Test\TestCase;

use Cake\Database\Connection;
use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use RuntimeException;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Integration test.
 */
trait DatabaseTestTrait
{
    use ContainerTestTrait;

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->bootApp();

        $this->setUpDatabase();
    }

    /** {@inheritdoc} */
    protected function tearDown()
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
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->getConnection()->getDriver()->getConnection();
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
        $this->migrate();

        define('DB_TEST_TRAIT_INIT', 1);

        return true;
    }

    /**
     * Prepare the database schema.
     *
     * @throws RuntimeException
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
     * Clean-Up Database. Truncate tables.
     *
     * @throws RuntimeException
     *
     * @return void
     */
    protected function dropTables(): void
    {
        $sql = 'SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = database()';

        $db = $this->getPdo();

        $db->exec('SET UNIQUE_CHECKS=0;');
        $db->exec('SET FOREIGN_KEY_CHECKS=0;');

        $statement = $db->query($sql);

        if (!$statement) {
            throw new RuntimeException('Invalid sql statement');
        }

        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $db->exec(sprintf('DROP TABLE `%s`;', $row['table_name']));
        }

        $db->exec('SET UNIQUE_CHECKS=1;');
        $db->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Clean-Up Database. Truncate tables.
     *
     * @throws RuntimeException
     *
     * @return void
     */
    protected function truncateTables(): void
    {
        $sql = 'SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = database()
                AND update_time IS NOT NULL';

        $db = $this->getPdo();

        $db->exec('SET UNIQUE_CHECKS=0;');
        $db->exec('SET FOREIGN_KEY_CHECKS=0;');

        $statement = $db->query($sql);

        if (!$statement) {
            throw new RuntimeException('Invalid sql statement');
        }

        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $db->exec(sprintf('TRUNCATE TABLE `%s`;', $row['table_name']));
        }

        $db->exec('SET UNIQUE_CHECKS=1;');
        $db->exec('SET FOREIGN_KEY_CHECKS=1;');
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
        $pdo = $this->getPdo();
        foreach ($fixtures as $fixture) {
            $object = new $fixture();
            $table = $object->table;
            $pdo->exec(sprintf('TRUNCATE TABLE `%s`;', $table));

            foreach ($object->records as $row) {
                $db->newQuery()->insert(array_keys($row))->into($table)->values($row)->execute();
            }
        }
    }
}
