<?php

echo "\033[32m*** Slim Setup ***\e[0m\n";

$dbHost = readline('Enter the database hostname or ip [127.0.0.1]:') ?: '127.0.0.1';
$dbPort = readline('Enter the database port [3306]:') ?: '3306';
$dbName = readline('Enter the DEV database name [slim_example]:') ?: 'slim_example';
$dbNameTest = readline('Enter the TEST database name [slim_example_test]:') ?: 'slim_example_test';
$dbUsername = readline('Enter the database username [root]:') ?: 'root';
$dbPassword = readline('Enter the database password [empty]:') ?: '';

echo "Open TEST database connection\n";

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdoTest = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUsername, $dbPassword, $pdoOptions);
    echo "Create TEST database\n";
    $pdoTest->exec("CREATE DATABASE IF NOT EXISTS `$dbNameTest` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

    $pdoTest = null;
} catch (Exception $exception) {
    echo "\033[32mTEST database connection failed.\e[0m\n";
    echo $exception->getMessage() . "\n";
    exit;
}

echo "\033[32mTEST database connection successfully\e[0m\n";

try {
    echo "Connect to DEV database server\n";
    $pdo = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUsername, $dbPassword, $pdoOptions);

    echo "Create DEV database\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `$dbName`;");
} catch (Exception $exception) {
    echo "\033[32mDEV database connection failed.\e[0m\n";
    echo $exception->getMessage() . "\n";
    exit;
}

echo "\033[32mDEV database created successfully\e[0m\n";

echo "Import database schema\n";
$pdo->exec(file_get_contents(__DIR__ . '/../resources/schema/schema.sql'));

echo "Create local env.php file\n";

$code = [
    "<?php",
    "",
    "// Secret credentials",
    "",
    "return function (array \$settings): array {",
    "",
    "    \$settings['db']['host'] = '$dbHost';",
    "    \$settings['db']['port'] = '$dbPort';",
    "    \$settings['db']['username'] = '$dbUsername';",
    "    \$settings['db']['password'] = '$dbPassword';",
    "",
    "    if (defined('PHPUNIT_COMPOSER_INSTALL')) {",
    "        // PHPUnit test database",
    "        \$settings['db']['database'] = '$dbNameTest';",
    "    } else {",
    "        // Local dev database",
    "        \$settings['db']['database'] = '$dbName';",
    "    }",
    "",
    "    return \$settings;",
    "};",
    "",
];

if (!file_exists(__DIR__ . '/../config/env2.php')) {
    file_put_contents(__DIR__ . '/../config/env2.php', implode("\n", $code));
}

echo "\033[32mSetup was successfully!\e[0m\n";
echo "To start all tests, run: composer test\n";
echo "To start the internal webserver, run: composer start\n";
