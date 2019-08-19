<?php

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// Fix apache base path.
// Change the request uri to run the app in a subdirectory.
call_user_func(static function () {
    if (!isset($_SERVER['REQUEST_URI'])) {
        return;
    }
    $path = parse_url($_SERVER['REQUEST_URI'])['path'];
    $scriptName = dirname(dirname($_SERVER['SCRIPT_NAME']));
    $len = strlen($scriptName);
    if ($len > 0 && $scriptName !== '/') {
        $path = substr($path, $len);
    }
    $_SERVER['REQUEST_URI'] = $path ?: '';
});

$app = AppFactory::create();

// Add middleware
require __DIR__ . '/middleware.php';

// Define app routes
require __DIR__ . '/routes.php';

return $app;
