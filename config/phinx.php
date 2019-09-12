<?php

use App\Utility\Configuration;
use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/bootstrap.php';

$container = $app->getContainer();
$pdo = $container->get(PDO::class);
$config = $container->get(Configuration::class);
$database = $config->get('db')['database'];
$phinx = $config->get('phinx');

$phinx['environments']['local'] = [
    // Set database name
    'name' => $database,
    'connection' => $pdo,
];

return $phinx;
