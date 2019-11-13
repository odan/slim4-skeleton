<?php

use App\Middleware\LocaleSessionMiddleware;
use App\Middleware\TranslatorMiddleware;
use Selective\Config\Configuration;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    $container = $app->getContainer();

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(ValidationExceptionMiddleware::class);

    // Twig
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    // Translation middleware
    $app->add(TranslatorMiddleware::class);
    $app->add(LocaleSessionMiddleware::class);

    // Add global middleware to app
    $app->addRoutingMiddleware();

    // Error handler
    $settings = $container->get(Configuration::class)->getArray('error_handler_middleware');
    $displayErrorDetails = (bool)$settings['display_error_details'];
    $logErrors = (bool)$settings['log_errors'];
    $logErrorDetails = (bool)$settings['log_error_details'];

    $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
};
