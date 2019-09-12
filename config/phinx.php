<?php

use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/bootstrap.php';

$container = $app->getContainer();
$pdo = $container->get(PDO::class);
$database = $container->get('settings')['db']['database'];
$phinx = $container->get('settings')['phinx'];

$phinx['environments']['local'] = [
    // Set database name
    'name' => $database,
    'connection' => $pdo,
];

return $phinx;
