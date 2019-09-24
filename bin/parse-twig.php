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

use App\Startup;
use App\Utility\Configuration;
use Odan\Twig\TwigCompiler;
use Slim\Views\Twig;

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_ENV', 'integration');

$app = Startup::boostrap();

// Read twig settings
$settings = $app->getContainer()->get(Configuration::class)->get('twig');
$cachePath = (string)$settings['cache_path'];

$twig = $app->getContainer()->get(Twig::class)->getEnvironment();

// Compile twig templates (*.twig) to PHP code
$compiler = new TwigCompiler($twig, $cachePath, true);
$compiler->compile();

echo "Done\n";

return 0;
