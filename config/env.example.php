<?php

/**
 * Environment specific application configuration.
 *
 * You should store all secret information (username, password, tokens, private keys) here.
 *
 * Make sure the env.php file is added to your .gitignore,
 * so it is not checked-in the code
 *
 * Place the env.php _outside_ the project root directory, to protect against
 * overwriting at deployment.
 *
 * This usage ensures that no sensitive passwords or API keys will
 * ever be in the version control history so there is less risk of
 * a security breach, and production values will never have to be
 * shared with all project collaborators.
 */

// Optional: Load the settings from an environment variable
// $environment = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'test';
// if ($environment) {
//    require __DIR__ . '/local.' . $environment . '.php';
// }

// For DEV and TEST: Detect phpunit test environment
// if (defined('PHPUNIT_COMPOSER_INSTALL')) {
//    // TEST (phpunit)
//    require __DIR__ . '/local.test.php';
// } else {
//    // Local DEV
//    require __DIR__ . '/local.dev.php';
// }

// On PROD include just this file
// require __DIR__ . '/local.prod.php';

// Database
$settings['db']['username'] = 'root';
$settings['db']['password'] = '';

// Docker example
// if (isset($_ENV['DOCKER'])) {
//    $settings['db']['host'] = $_ENV['MYSQL_HOST'] ?? 'host.docker.internal';
//    $settings['db']['port'] = $_ENV['MYSQL_PORT'] ?? '3306';
//    $settings['db']['username'] = $_ENV['MYSQL_USER'] ?? 'root';
//    $settings['db']['password'] = $_ENV['MYSQL_PASSWORD'] ?? '';
// }

$settings['api_auth'] = [
    'users' => [
        'api-admin' => 'secret',
        'api-user' => 'secret',
    ],
];

$settings['phoenix']['environments']['local']['db_name'] = $settings['db']['database'];
$settings['phoenix']['environments']['local']['username'] = $settings['db']['username'];
$settings['phoenix']['environments']['local']['password'] = $settings['db']['password'];
