<?php

return function (array $settings): array {
    // Database
    $settings['db']['host'] = '127.0.0.1';
    $settings['db']['database'] = 'slim_skeleton_test';
    $settings['db']['username'] = 'root';
    $settings['db']['password'] = '';

    return $settings;
};
