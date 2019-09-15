<?php

use App\Startup;
use App\Utility\Configuration;

$app = Startup::boostrap();

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
