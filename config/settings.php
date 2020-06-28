<?php

// Defaults
$settings = require __DIR__ . '/defaults.php';

// Load environment configuration
if (file_exists(__DIR__ . '/../../env.php')) {
    require __DIR__ . '/../../env.php';
} elseif (file_exists(__DIR__ . '/env.php')) {
    require __DIR__ . '/env.php';
}

// Testing and integration environment
if (isset($_ENV['APP_ENV'])) {
    require __DIR__ . '/env.' . $_ENV['APP_ENV'] . '.php';
}

return $settings;
