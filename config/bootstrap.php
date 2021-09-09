<?php

use App\Factory\ContainerFactory;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// Build PHP-DI Container instance
$container = (new ContainerFactory())->createInstance();

// Create App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

return $app;
