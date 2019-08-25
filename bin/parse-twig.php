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
use Twig\Environment as Twig;

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

$settings = $app->getContainer()->get('settings')['twig'];
$templatePath = (string)$settings['path'];
$cachePath = (string)$settings['cache_path'];

$twig = $app->getContainer()->get(Twig::class);

$compiler = new TwigCompiler($twig, $cachePath);
$compiler->compile();
