<?php

use App\Application;
use App\Utility\Configuration;

$app = Application::boostrap();

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
