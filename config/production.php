<?php

// Production environment
$settings['env'] = 'production';

$settings['error']['display_error_details'] = false;
$settings['logger']['level'] = \Monolog\Logger::INFO;
$settings['router']['cache_file'] = $settings['temp'] . '/routes/routes.php';

// Database
$settings['db']['database'] = 'slim_skeleton';
