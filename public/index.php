<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// Fix apache base path.
// Change the request uri to run the app in a subdirectory.
call_user_func(static function () {
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
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', static function (Request $request, Response $response) {
    $response->getBody()->write('Hello, World!');

    return $response;
});

$app->get('/hello/{name}', static function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Run app
$app->run();