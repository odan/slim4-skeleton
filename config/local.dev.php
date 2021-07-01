<?php

// Developers desktop/workstation

error_reporting(E_ALL);
ini_set('display_errors', '1');

$settings['error']['display_error_details'] = true;
$settings['logger']['level'] = \Monolog\Logger::DEBUG;

// Database
$settings['db']['database'] = 'slim_skeleton_dev';
