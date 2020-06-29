<?php

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Overwrite default settings with environment specific local settings
if (file_exists(__DIR__ . '/../../env.php')) {
    require __DIR__ . '/../../env.php';
} elseif (file_exists(__DIR__ . '/env.php')) {
    require __DIR__ . '/env.php';
}

// Testing and integration environment
if (isset($_ENV['APP_ENV'])) {
    require __DIR__ . '/local.' . $_ENV['APP_ENV'] . '.php';
}

return $settings;
