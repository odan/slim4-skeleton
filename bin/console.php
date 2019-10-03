<?php

use App\Utility\Configuration;
use Symfony\Component\Console\Application;

if (isset($_SERVER['REQUEST_METHOD'])) {
    echo "Only CLI allowed. Script stopped.\n";
    exit (1);
}

require_once __DIR__ . '/../vendor/autoload.php';

$container = \App\Startup::boostrap()->getContainer();

$commands = (array)$container->get(Configuration::class)->get('commands');
$application = new Application();

foreach ($commands as $class) {
    $application->add($container->get($class));
}

$application->run();
