<?php

use Slim\App;

/** @var App $app */
$app = require __DIR__ . '/config/bootstrap.php';

$container = $app->getContainer();

// @phpstan-ignore-next-line
return $app->getContainer()->get('settings')['phoenix'];
