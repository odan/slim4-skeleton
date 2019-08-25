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

use Slim\App;
use Twig\Environment as Twig;

/** @var App $app */
$app = require __DIR__ . '/../config/bootstrap.php';

$settings = $app->getContainer()->get('settings')['twig'];
$templatePath = (string)$settings['path'];
$cachePath = (string)$settings['cache_path'];

$twig = $app->getContainer()->get(Twig::class);

$twig->disableDebug();

// Force auto-reload to always have the latest version of the template
$twig->enableAutoReload();

// The Twig cache must be enabled
$twig->setCache($cachePath);

// Iterate over all your templates
$directory = new RecursiveDirectoryIterator($templatePath, FilesystemIterator::SKIP_DOTS);

foreach (new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST) as $file) {
    /** @var SplFileInfo $file */
    if ($file->isFile() && $file->getExtension() === 'twig') {
        $templateName = substr($file->getPathname(), strlen($templatePath) + 1);
        $templateName = str_replace('\\', '/', $templateName);
        echo sprintf("Parsing: %s\n", $templateName);
        $twig->loadTemplate($templateName);
    }
}
