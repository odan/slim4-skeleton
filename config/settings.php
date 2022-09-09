<?php

// Load .env file if located in the project root directory
// (\Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'))->safeLoad();

// Define environment
$_ENV['APP_ENV'] = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'dev';

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Overwrite default settings with environment specific local settings
$configFiles = sprintf('%s/{local.%s,env,../../env}.php', __DIR__, $_ENV['APP_ENV']);

foreach (glob($configFiles, GLOB_BRACE) as $file) {
    $local = require $file;
    if (is_callable($local)) {
        $settings = $local($settings);
    }
}

return $settings;
