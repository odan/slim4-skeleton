<?php

// Testing environment
$settings['env'] = 'testing';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

$settings['router']['cache_file'] = $settings['temp'] . '/route-cache.php';

// Database
$settings['db']['database'] = 'test_dbname';
