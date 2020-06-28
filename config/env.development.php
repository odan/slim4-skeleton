<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$settings['env'] = 'development';

$settings['twig']['options']['cache_enabled'] = false;
$settings['translation']['cache_enabled'] = false;

// Database
$settings['db']['database'] = 'slim_skeleton_dev';
