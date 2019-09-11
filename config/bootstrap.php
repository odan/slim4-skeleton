<?php

use Psr\Container\ContainerInterface;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

return (static function () {
    /** @var ContainerInterface $container */
    $container = require __DIR__ . '/container.php';

    // Create App instance
    $app = $container->get(App::class);

    // Register routes
    (require __DIR__ . '/routes.php')($app);

    // Register middleware
    (require __DIR__ . '/middleware.php')($app);

    return $app;
})();
