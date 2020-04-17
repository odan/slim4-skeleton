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

// Error handler
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => true,
    // Should be set to false for unit tests
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
    'level' => \Monolog\Logger::DEBUG,
    'file_permission' => 0775,
];

// Twig settings
// Configuration reference: https://symfony.com/doc/current/reference/configuration/twig.html
$settings['twig'] = [
    // Template paths
    'paths' => [
        __DIR__ . '/../templates',
    ],
    // Twig environment options
    'options' => [
        // Should be set to true in production
        'cache_enabled' => true,
        'cache_path' => $settings['temp'] . '/twig',
    ],
];

// Session
$settings['session'] = [
    'name' => 'webapp',
    'cache_expire' => 0,
];

// Translation settings
$settings['translation'] = [
    'path' => $settings['root'] . '/resources/translations',
    'cache_enabled' => true,
    'cache_path' => $settings['temp'] . '/translations',
    // Default language
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
    'default_migration_prefix' => 'db_change_',
    'generate_migration_name' => true,
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'local',
        'local' => [],
    ],
];

// Database settings
$settings['db'] = [
    'driver' => \Cake\Database\Driver\Mysql::class,
    'host' => 'localhost',
    'encoding' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    // Enable identifier quoting
    'quoteIdentifiers' => true,
    // Set to null to use MySQL servers timezone
    'timezone' => null,
    // Disable meta data cache
    'cacheMetadata' => false,
    // Disable query logging
    'log' => false,
    // PDO options
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
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

// Console commands
$settings['commands'] = [
    \App\Console\TwigCompilerCommand::class,
    \App\Console\SchemaDumpCommand::class,
];

return $settings;
