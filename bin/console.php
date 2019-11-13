<?php

use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;
use Symfony\Component\Console\Application;

if (isset($_SERVER['REQUEST_METHOD'])) {
    echo "Only CLI allowed. Script stopped.\n";
    exit(1);
}

/** @var ContainerInterface $container */
$container = (require __DIR__ . '/../config/bootstrap.php')->getContainer();

$commands = $container->get(Configuration::class)->getArray('commands');
$application = new Application();

foreach ($commands as $class) {
    $application->add($container->get($class));
}

$application->run();
