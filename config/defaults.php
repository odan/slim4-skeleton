<?php

// Configure defaults for the whole application.

// Error reporting
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/Berlin');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error_handler_middleware'] = [
    // Should be set to false in production
    'display_error_details' => true,
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];

// Application settings
$settings['app'] = [
    'secret' => '{{app_secret}}',
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => $settings['root'] . '/logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::ERROR,
    'file_permission' => 0775,
];

// View settings
$settings['twig'] = [
    'path' => $settings['root'] . '/templates',
    // Should be set to true in production
    'cache_enabled' => true,
    'cache_path' => $settings['temp'] . '/twig-cache',
];

// Assets
$settings['assets'] = [
    // Public assets cache directory
    'path' => $settings['public'] . '/cache',
    'url_base_path' => 'cache/',
    // Cache settings
    'cache_enabled' => true,
    'cache_path' => $settings['temp'],
    'cache_name' => 'assets-cache',
    // Enable JavaScript and CSS compression
    'minify' => 1,
];

// Session
$settings['session'] = [
    'name' => 'webapp',
    'cache_expire' => 0,
];

// Locale settings
$settings['locale'] = [
    'path' => $settings['root'] . '/resources/locale',
    'cache' => $settings['temp'] . '/locale-cache',
    'locale' => 'en_US',
    'domain' => 'messages',
    // Should be set to false in production
    'debug' => false,
];

// Phinx settings
$settings['phinx'] = [
    'paths' => [
        'migrations' => $settings['root'] . '/resources/migrations',
        'seeds' => $settings['root'] . '/resources/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'local',
        'local' => [],
    ],
];

// CSRF middleware settings
$settings['csrf'] = [
    'secret' => '{{app_secret}}',
    'token_name' => '__token',
    'protect_ajax' => false,
    'protect_forms' => true,
];

// Database settings
$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'encoding' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'flags' => [
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Set default fetch mode
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

// E-Mail settings
$settings['smtp'] = [
    'type' => 'smtp',
    'host' => '127.0.0.1',
    'port' => '25',
    'secure' => '',
    'from' => 'from@example.com',
    'from_name' => 'My name',
    'to' => 'to@example.com',
];

return $settings;
