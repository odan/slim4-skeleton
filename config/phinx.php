<?php

use Cake\Core\Configure;
use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

Configure::write('App.namespace', 'App');

$container = $app->getContainer();
// @phpstan-ignore-next-line
$pdo = $container->get(PDO::class);
// @phpstan-ignore-next-line
$settings = $container->get('settings');
$database = $settings['db']['database'];
$phinx = $settings['phinx'];

$phinx['environments']['local'] = [
    // Set database name
    'name' => $database,
    'connection' => $pdo,
];

return $phinx;
