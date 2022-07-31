<?php

namespace App\Console;

use Exception;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SetupCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();

        $this->setName('setup');
        $this->setDescription('Configuration and database installation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>**** Slim Setup ****</info>');

        if (file_exists(__DIR__ . '/../../config/env.php')) {
            $output->writeln('<error>The file config/env.php already exists.</error>');

            return 1;
        }

        $dbHost = readline('Enter the database hostname or ip address [127.0.0.1]:') ?: '127.0.0.1';
        $dbPort = readline('Enter the database port [3306]:') ?: '3306';
        $dbName = readline('Enter the DEV database name [slim_example]:') ?: 'slim_example';
        $dbNameTest = readline('Enter the TEST database name [slim_example_test]:') ?: 'slim_example_test';
        $dbUsername = readline('Enter the database username [root]:') ?: 'root';
        $dbPassword = readline('Enter the database password [empty]:') ?: '';

        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        try {
            $output->writeln('Open TEST database connection');
            $pdoTest = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUsername, $dbPassword, $pdoOptions);

            $output->writeln('Create TEST database');
            $pdoTest->exec(
                "CREATE DATABASE IF NOT EXISTS `$dbNameTest` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
            );

            $pdoTest = null;
        } catch (Exception $exception) {
            $output->writeln('<error>TEST database connection failed.</error>');
            $output->writeln($exception->getMessage());

            return 1;
        }

        $output->writeln('<info>TEST database connection successfully</info>');

        try {
            $output->writeln('Connect to DEV database server');
            $pdo = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUsername, $dbPassword, $pdoOptions);

            $output->writeln('Create DEV database');
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$dbName`;");
        } catch (Exception $exception) {
            $output->writeln('<error>DEV database connection failed.</error>');
            $output->writeln($exception->getMessage());

            return 1;
        }

        $output->writeln('<info>DEV database created successfully</info>');

        $output->writeln('Import database schema');
        $pdo->exec((string)file_get_contents(__DIR__ . '/../../resources/schema/schema.sql'));
        $pdo = null;

        $output->writeln('Create config/env.php file');

        $code = [
            '<?php',
            '',
            '// Secret credentials',
            '',
            'return function (array $settings): array {',
            '',
            "    \$settings['db']['host'] = '$dbHost';",
            "    \$settings['db']['port'] = '$dbPort';",
            "    \$settings['db']['username'] = '$dbUsername';",
            "    \$settings['db']['password'] = '$dbPassword';",
            '',
            "    if (defined('PHPUNIT_COMPOSER_INSTALL')) {",
            '        // PHPUnit test database',
            "        \$settings['db']['database'] = '$dbNameTest';",
            '    } else {',
            '        // Local dev database',
            "        \$settings['db']['database'] = '$dbName';",
            '    }',
            '',
            '    return $settings;',
            '};',
            '',
        ];

        file_put_contents(__DIR__ . '/../../config/env.php', implode("\n", $code));

        $output->writeln('<info>Setup was successfully!</info>');
        $output->writeln('To start all tests, run: composer test');
        $output->writeln('To start the internal webserver, run: composer start');

        return 0;
    }
}
