<?php

use App\Factory\ContainerFactory;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// Build DI Container instance
$container = (new ContainerFactory())->createInstance();

// Create App instance
return $container->get(App::class);
