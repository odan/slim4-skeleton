---
layout: default
title: Middleware
parent: The Basics
---

# Middleware

The Middleware concept provides a convenient mechanism for inspecting and filtering 
HTTP requests entering your application. 

For example, this Slim Skeleton project
includes a middleware that verifies the user of your application is authenticated. 
If the user is not authenticated, the middleware will return a `401 Unauthorized`
response. However, if the user is authenticated, the middleware will allow the 
request to proceed further into the application.

## Registering Middleware

### Global middleware

If you want a middleware to run during every HTTP request to your application, 
list the middleware class in the file: 
[config/middleware.php](https://github.com/odan/slim4-skeleton/blob/master/config/middleware.php)

### Assigning Middleware To Routes

If you would like to assign middleware to specific routes, 
you should first assign the middleware a key in `config/container.php`.

You can add middleware to all routes, 
to a specific route or to a group of routes.
This makes it easier to differentiate between public and protected areas, 
as well as API resources etc.

Once the middleware has been defined in the DI container,
you may use the `add` method to assign the middleware to a route
using the fully qualified class name:

```php
$app->get('/my-path', \App\Action\MyAction::class)->add(MyMiddleware::class);
```

Assigning middleware to a group of routes:

```php
use Slim\Routing\RouteCollectorProxy;

// ...

$app->group(
    '/my-route-group',
    function (RouteCollectorProxy $app) {
        $app->get('/sub-resource', \App\Action\MyAction::class);
       // ...
    }
)->add(MyMiddleware::class);
```

## Read more

* [Slim 4 - Middleware](https://www.slimframework.com/docs/v4/concepts/middleware.html) (Documentation)
* [Slim 4 - Routing](https://www.slimframework.com/docs/v4/objects/routing.html) (Documentation)
