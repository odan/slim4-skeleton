<?php

// Load .env file, if exists
use Symfony\Component\Dotenv\Dotenv;

$envFiles = [
    __DIR__ . '/.env',
    __DIR__ . '/../../.env',
];

if (class_exists(Dotenv::class)) {
    $dotenv = new Dotenv();
    foreach ($envFiles as $envFile) {
        if (file_exists($envFile)) {
            $dotenv->load($envFile);
        }
    }
}

// Detect environment
$_ENV['APP_ENV'] ??= $_SERVER['APP_ENV'] ?? 'dev';

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Overwrite default settings with environment specific local settings
$configFiles = [
    __DIR__ . sprintf('/local.%s.php', $_ENV['APP_ENV']),
    __DIR__ . '/env.php',
    __DIR__ . '/../../env.php',
];

foreach ($configFiles as $configFile) {
    if (!file_exists($configFile)) {
        continue;
    }

    $local = require $configFile;
    if (is_callable($local)) {
        $settings = $local($settings);
    }
}

return $settings;
