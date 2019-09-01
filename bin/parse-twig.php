<?php

//
// Twig to PHP compiler.
//
// Usage: php bin/parse-twig.php
//
// Start Poedit and open the file: resources/locale/*.po
// Open menu: Catalog > Properties > Source Path
// Add source path: tmp/twig-cache
//
// Open tab: Sources keywords
// Add keyword: __
// Click 'Ok' to store the settings
//
// Click button 'Update form source' to extract the template strings.
// Translate the text and save the file.
//

use Odan\Twig\TwigCompiler;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigRuntimeLoader;

define('APP_ENV', 'integration');

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

$settings = $app->getContainer()->get('settings')['twig'];
$templatePath = (string)$settings['path'];
$cachePath = (string)$settings['cache_path'];

$twig = $app->getContainer()->get(Twig::class)->getEnvironment();

$routeParser = $app->getRouteCollector()->getRouteParser();
$basePath = $app->getBasePath();
$factory = new ServerRequestFactory();
$request = $factory->createServerRequest('GET', '/');
$runtimeLoader = new TwigRuntimeLoader($routeParser, $request->getUri(), $basePath);
$twig->addRuntimeLoader($runtimeLoader);
$twig->addExtension(new TwigExtension());

$compiler = new TwigCompiler($twig, $cachePath, true);
$compiler->compile();

echo "Done\n";

return 0;
