<?php

use App\Handler\HtmlErrorRenderer;
use App\Handler\JsonErrorRenderer;
use App\Middleware\LocaleSessionMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\TranslatorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Selective\Config\Configuration;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $container = $app->getContainer();

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(ValidationExceptionMiddleware::class);
    $app->add(TwigMiddleware::class);
    $app->add(TranslatorMiddleware::class);
    $app->add(LocaleSessionMiddleware::class);
    $app->add(SessionMiddleware::class);
    $app->addRoutingMiddleware();
    $app->add(BasePathMiddleware::class);

    // Error handler
    $settings = $container->get(Configuration::class)->getArray('error_handler_middleware');
    $displayErrorDetails = (bool)$settings['display_error_details'];
    $logErrors = (bool)$settings['log_errors'];
    $logErrorDetails = (bool)$settings['log_error_details'];

    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);

    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->registerErrorRenderer('text/html', HtmlErrorRenderer::class);
    $errorHandler->registerErrorRenderer('application/json', JsonErrorRenderer::class);
};
