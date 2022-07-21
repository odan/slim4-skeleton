<?php

// Production environment

return function (array $settings): array {
    $settings['db']['database'] = 'slim_skeleton';

    return $settings;
};
