---
layout: default
title: Routing
nav_order: 6
---

# Routing

The Slim Framework handles the routing and delegates the request to the appropriate route handler.

[Read more](http://www.slimframework.com/docs/v4/objects/routing.html)

## Routes

All the routes are defined in [config/routes.php](https://github.com/odan/slim4-skeleton/blob/master/config/routes.php).

Each route will be defined by a method that corresponds to the HTTP verb. 

For example, a `GET` request is defined as follows:

```php
$app->get('/users', \App\Action\User\UserFindAction::class);
```

## Route groups

Route groups are good to organize routes into logical groups. [Read more](http://www.slimframework.com/docs/v4/objects/routing.html#route-groups)

