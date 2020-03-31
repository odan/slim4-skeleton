<?php

use App\Middleware\LocaleSessionMiddleware;
use App\Middleware\TranslatorMiddleware;
use Odan\Session\SessionMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(ValidationExceptionMiddleware::class);
    $app->add(TwigMiddleware::class);
    $app->add(TranslatorMiddleware::class);
    $app->add(LocaleSessionMiddleware::class);
    $app->add(SessionMiddleware::class);
    $app->addRoutingMiddleware();
    $app->add(BasePathMiddleware::class);
    $app->add(ErrorMiddleware::class);
};
