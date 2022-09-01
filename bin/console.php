<?php

use App\Factory\ContainerFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

require_once __DIR__ . '/../vendor/autoload.php';

$env = (new ArgvInput())->getParameterOption(['--env', '-e'], 'dev');

if ($env) {
    $_ENV['APP_ENV'] = $env;
}

/** @var ContainerInterface $container */
$container = ContainerFactory::createInstance();

try {
    /** @var Application $application */
    $application = $container->get(Application::class);
    exit($application->run());
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}
