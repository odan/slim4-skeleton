<?php

// Phpunit testing environment

use Monolog\Handler\NoopHandler;
use Monolog\Logger;

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database
$settings['db']['database'] = 'slim_skeleton_test';

// Mocked Logger settings
$logger = new Logger('testing');
$logger->pushHandler(new NoopHandler());

$settings['logger'] = [
    'path' => '',
    'level' => 0,
    'test' => $logger,
];
