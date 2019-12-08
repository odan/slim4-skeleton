<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Continuous integration environment
$settings['env'] = 'integration';

$settings['error_handler_middleware']['log_errors'] = false;

$settings['logger']['level'] = \Monolog\Logger::DEBUG;
$settings['assets']['minify'] = 0;
$settings['locale']['cache'] = null;
$settings['twig']['cache_enabled'] = false;

// Database
$settings['db']['database'] = 'test';
