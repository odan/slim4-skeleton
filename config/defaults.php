<?php

// Application default settings

// Error reporting
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Timezone
date_default_timezone_set('Europe/Berlin');

$settings = [];

// Environment
$settings['env'] = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'dev';

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = __DIR__ . '/../tmp';
$settings['public'] = __DIR__ . '/../public';
$settings['template'] = __DIR__ . '/../templates';

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,
    // Should be set to false for the test environment
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => __DIR__ . '/../logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::INFO,
    'file_permission' => 0775,
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
        // Convert numeric values to strings when fetching.
        // Since PHP 8.1 integers and floats in result sets will be returned using native PHP types.
        // This option restores the previous behavior.
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ],
];

// Phoenix settings
$settings['phoenix'] = [
    'migration_dirs' => [
        'first' => __DIR__ . '/../resources/migrations',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'username' => 'root',
            'password' => '',
            'db_name' => 'slim_skeleton_dev',
            'charset' => 'utf8',
        ],
        'local2' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'username' => 'root',
            'password' => 'root',
            'db_name' => 'slim_skeleton_diff',
            'charset' => 'utf8',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];

// Console commands
$settings['commands'] = [
    \App\Console\SchemaDumpCommand::class,
];

return $settings;
