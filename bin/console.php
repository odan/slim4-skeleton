<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

require_once __DIR__ . '/../vendor/autoload.php';

$env = (new ArgvInput())->getParameterOption(['--env', '-e'], 'development');

if ($env) {
    $_ENV['APP_ENV'] = $env;
}

/** @var ContainerInterface $container */
$container = (require __DIR__ . '/../config/bootstrap.php')->getContainer();

$application = $container->get(Application::class);
$application->run();
