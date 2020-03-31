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
    'display_error_details' => false,
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests it should be disable too
    'log_errors' => false,
    // Display error details in error log
    'log_error_details' => true,
];

$settings['router'] = [
    // Should be set only in production
    'cache_file' => '',
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
    // Template paths
    'path' => [
        $settings['root'] . '/templates',
    ],
    // Twig environment settings
    'settings' => [
        // The cache path or false (no cache)
        'cache' => $settings['temp'] . '/twig-cache',
    ],
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
    'default_migration_prefix' => 'db_change_',
    'generate_migration_name' => true,
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'local',
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
    \App\Console\SchemaSqlCommand::class,
];

return $settings;
