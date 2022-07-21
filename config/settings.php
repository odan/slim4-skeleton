<?php

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Overwrite default settings with environment specific local settings
$configFiles = sprintf('%s/{local.%s,env,../../env,phoenix}.php', __DIR__, $settings['env']);

foreach (glob($configFiles, GLOB_BRACE) as $file) {
    $local = require $file;
    if (is_callable($local)) {
        $settings = $local($settings);
    }
}

return $settings;
