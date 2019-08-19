<?php

// Define app routes

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

/** @var App $app */

$app->get('/', static function (Request $request, Response $response) {
    $response->getBody()->write('Hello, World!');

    return $response;
});

$app->get('/hello/{name}', static function (Request $request, Response $response, $args) {
    $name = $args['name'];

    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->post('/users', static function (Request $request, Response $response) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(['result' => ['success' => true]]));

    return $response;
});
