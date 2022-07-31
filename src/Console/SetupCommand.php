<?php

namespace App\Console;

use Exception;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UnexpectedValueException;

final class SetupCommand extends Command
{
    private string $dbHost;
    private string $dbPort;
    private string $dbName;
    private string $dbNameTest;
    private string $dbUsername;
    private string $dbPassword;
    private array $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    protected function configure(): void
    {
        parent::configure();

        $this->setName('setup');
        $this->setDescription('Configuration and database installation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>*** Slim Setup ***</info>');

        try {
            if (file_exists(__DIR__ . '/../../config/env.php')) {
                throw new UnexpectedValueException('The file config/env.php already exists.');
            }

            $this->askDbParameters();
            $this->setupDatabase($output);

            $output->writeln('Create config/env.php file');
            $this->safeEnvFile();

            $output->writeln('<info>Setup was successfully!</info>');
            $output->writeln('To start all tests, run: composer test');
            $output->writeln('To start the internal webserver, run: composer start');

            return 0;
        } catch (Exception $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

            return 1;
        }
    }

    private function askDbParameters(): void
    {
        $this->dbHost = $this->ask('Enter the database hostname or ip address', '127.0.0.1');
        $this->dbPort = $this->ask('Enter the database port', '3306');
        $this->dbName = $this->ask('Enter the DEV database name', 'slim');
        $this->dbNameTest = $this->ask('Enter the TEST database name', 'slim_test');
        $this->dbUsername = $this->ask('Enter the database username', 'root');
        $this->dbPassword = $this->ask('Enter the database password', '');
    }

    private function ask(string $question, string $default): string
    {
        return (string)readline(sprintf('%s [%s]:', $question, $default)) ?: $default;
    }

    private function createTableSql(string $table): string
    {
        return sprintf('CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;', $table);
    }

    private function useSql(string $database): string
    {
        return sprintf('USE `%s`;', $database);
    }

    private function safeEnvFile(): void
    {
        $code = [
            '<?php',
            '',
            '// Secret credentials',
            '',
            'return function (array $settings): array {',
            '',
            "    \$settings['db']['host'] = '$this->dbHost';",
            "    \$settings['db']['port'] = '$this->dbPort';",
            "    \$settings['db']['username'] = '$this->dbUsername';",
            "    \$settings['db']['password'] = '$this->dbPassword';",
            '',
            "    if (defined('PHPUNIT_COMPOSER_INSTALL')) {",
            '        // PHPUnit test database',
            "        \$settings['db']['database'] = '$this->dbNameTest';",
            '    } else {',
            '        // Local dev database',
            "        \$settings['db']['database'] = '$this->dbName';",
            '    }',
            '',
            '    return $settings;',
            '};',
            '',
        ];

        file_put_contents(__DIR__ . '/../../config/env.php', implode("\n", $code));
    }

    private function createDatabase(PDO $pdo, string $database): void
    {
        $pdo->exec($this->createTableSql($database));
    }

    private function connectToDatabase(): PDO
    {
        return new PDO(
            "mysql:host=$this->dbHost;charset=utf8mb4",
            $this->dbUsername,
            $this->dbPassword,
            $this->pdoOptions
        );
    }

    private function existsDatabase(PDO $pdo, string $database): bool
    {
        $statement = $pdo->prepare('SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :database');
        $statement->bindValue('database', $database);
        $statement->execute();

        return !empty($statement->fetch());
    }

    private function setupDatabase(OutputInterface $output): void
    {
        $output->writeln('Connect to database server');
        $pdo = $this->connectToDatabase();

        if ($this->existsDatabase($pdo, $this->dbNameTest)) {
            throw new UnexpectedValueException("The database [$this->dbNameTest] already exists.");
        }

        if ($this->existsDatabase($pdo, $this->dbName)) {
            throw new UnexpectedValueException("The database [$this->dbName] already exists.");
        }

        $output->writeln('Create TEST database');
        $this->createDatabase($pdo, $this->dbNameTest);
        $output->writeln('<info>TEST database created successfully</info>');

        $output->writeln('Create DEV database');
        $this->createDatabase($pdo, $this->dbName);

        $output->writeln('Create DEV tables');
        $pdo->exec($this->createTableSql($this->dbName));
        $pdo->exec($this->useSql($this->dbName));
        $output->writeln('<info>DEV database created successfully</info>');

        $output->writeln('Import database schema');
        $pdo->exec((string)file_get_contents(__DIR__ . '/../../resources/schema/schema.sql'));
    }
}
