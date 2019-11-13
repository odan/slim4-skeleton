<?php

use Selective\Config\Configuration;
use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

$container = $app->getContainer();
$pdo = $container->get(PDO::class);
$config = $container->get(Configuration::class);
$database = $config->getString('db.database');
$phinx = $config->getArray('phinx');

$phinx['environments']['local'] = [
    // Set database name
    'name' => $database,
    'connection' => $pdo,
];

return $phinx;
