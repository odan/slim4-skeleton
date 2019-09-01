<?php

use App\Middleware\LocaleSessionMiddleware;
use App\Middleware\TranslatorMiddleware;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    $container = $app->getContainer();

    // Add global middleware to app
    $app->addRoutingMiddleware();

    // Translation middleware
    $app->add(TranslatorMiddleware::class);
    $app->add(LocaleSessionMiddleware::class);

    // Twig
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    // Error handler
    $settings = $container->get('settings')['error_handler_middleware'];
    $displayErrorDetails = (bool)$settings['display_error_details'];
    $logErrors = (bool)$settings['log_errors'];
    $logErrorDetails = (bool)$settings['log_error_details'];

    $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
};
