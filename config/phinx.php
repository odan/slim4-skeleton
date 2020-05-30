<?php

use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

$container = $app->getContainer();
// @phpstan-ignore-next-line
$pdo = $container->get(PDO::class);
// @phpstan-ignore-next-line
$config = $container->get('settings');
$database = $config['db']['database'];
$phinx = $config['phinx'];

$phinx['environments']['local'] = [
    // Set database name
    'name' => $database,
    'connection' => $pdo,
];

return $phinx;
