<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$settings['env'] = 'development';

$settings['error_handler_middleware']['display_error_details'] = true;
$settings['error_handler_middleware']['log_errors'] = true;

$settings['logger']['level'] = \Monolog\Logger::DEBUG;
$settings['assets']['minify'] = 0;
$settings['translation']['cache'] = null;
$settings['twig']['cache_enabled'] = false;

// Database
$settings['db']['database'] = 'slim_skeleton_dev';
