<?php

use App\Middleware\LocaleSessionMiddleware;
use App\Middleware\TranslatorMiddleware;
use Slim\App;

return static function (App $app) {
    $container = $app->getContainer();
    $settings = $container->get('settings');

    // Add global middleware to app
    $app->addRoutingMiddleware();

    // Translation middleware
    $app->add(TranslatorMiddleware::class);
    $app->add(LocaleSessionMiddleware::class);

    // Error handler
    $displayErrorDetails = (bool)$settings['error_handler_middleware']['display_error_details'];
    $logErrors = (bool)$settings['error_handler_middleware']['log_errors'];
    $logErrorDetails = (bool)$settings['error_handler_middleware']['log_error_details'];

    $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
};
