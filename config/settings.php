<?php

// Defaults
$settings = require __DIR__ . '/defaults.php';

// Load environment configuration
if (file_exists(__DIR__ . '/../../env.php')) {
    require __DIR__ . '/../../env.php';
} elseif (file_exists(__DIR__ . '/env.php')) {
    require __DIR__ . '/env.php';
}

// Unit-test and integration environment (Travis CI)
if (defined('APP_ENV')) {
    require __DIR__ . '/' . basename(APP_ENV) . '.php';
}

return $settings;
