<?php

// Production environment

return function (array $settings): array {
    $settings['db']['database'] = 'annodomini_dev';

    return $settings;
};
