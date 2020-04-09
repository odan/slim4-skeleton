<?php

namespace App\Console;

use PDO;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command.
 */
final class SchemaDumpCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The container
     * @param string|null $name The name
     */
    public function __construct(ContainerInterface $container, ?string $name = null)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    /**
     * Configure.
     *
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('schema-dump');
        $this->setDescription('Generate a schema.sql from the schema data source.');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input The input
     * @param OutputInterface $output The output
     *
     * @return int The error code, 0 on success
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Lazy loading, because the database may not exists
        $this->pdo = $this->container->get(PDO::class);

        $output->writeln(sprintf('Use database: %s', (string)$this->pdo->query('select database()')->fetchColumn()));

        $statement = $this->pdo->query('SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = database()');

        $sql = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $row = array_change_key_case($row);
            $statement2 = $this->pdo->query(sprintf('SHOW CREATE TABLE `%s`;', (string)$row['table_name']));
            $createTableSql = $statement2->fetch()['Create Table'];
            $sql[] = preg_replace('/AUTO_INCREMENT=\d+/', '', $createTableSql) . ';';
        }

        $sql = implode("\n\n", $sql);

        $filename = __DIR__ . '/../../resources/migrations/schema.sql';
        file_put_contents($filename, $sql);

        $output->writeln(sprintf('Generated file: %s', realpath($filename)));
        $output->writeln(sprintf('<info>Done</info>'));

        return 0;
    }
}
