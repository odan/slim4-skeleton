<?php

// Dev environment

return function (array $settings): array {
    $settings['error']['display_error_details'] = true;
    $settings['logger']['level'] = \Monolog\Logger::DEBUG;

    // Database
    $settings['db']['database'] = 'slim_skeleton_dev';

    return $settings;
};
