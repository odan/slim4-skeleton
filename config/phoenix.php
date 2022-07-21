<?php

return function (array $settings): array {
    // Copy credentials
    $settings['phoenix']['environments']['local']['db_name'] = $settings['db']['database'];
    $settings['phoenix']['environments']['local']['username'] = $settings['db']['username'];
    $settings['phoenix']['environments']['local']['password'] = $settings['db']['password'];

    return $settings;
};
