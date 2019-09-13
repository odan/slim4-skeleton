<?php

use App\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = Application::boostrap();

$pdo = $app->getContainer()->get(PDO::class);

echo sprintf("Use database: %s\n", $pdo->query('select database()')->fetchColumn());

$statement = $pdo->query('SELECT table_name FROM information_schema.tables WHERE table_schema = database()');

$sql = [];
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $statement2 = $pdo->query(sprintf('SHOW CREATE TABLE `%s`;', $row['table_name']));
    $createTableSql = $statement2->fetch()['Create Table'];
    $sql[] = preg_replace('/AUTO_INCREMENT=\d+/', '', $createTableSql) . ';';
}

$sql = implode("\n\n", $sql);

$filename = __DIR__ . '/../resources/migrations/schema.sql';
file_put_contents($filename, $sql);

echo sprintf("Generated file: %s\n", realpath($filename));
echo "Done\n";
