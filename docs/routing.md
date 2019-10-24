---
layout: default
title: Routing
nav_order: 6
---

# Routing

The Slim Framework handles the routing and delegates the request to the appropriate route handler.

[Read more](http://www.slimframework.com/docs/v4/objects/routing.html)

## Routes

All the app routes are defined in the [routes.php](https://github.com/odan/slim4-skeleton/blob/master/config/routes.php) file.

Every route is defined by a method corresponds to the HTTP verb. 

For example, a GET request to register a user is defined by:

```php
$group->get('/users', \App\Action\User\UserListAction::class);
```

### Predefined routes

* `GET /` => `Hello, World!`
* `GET /hello/john` => `Hello, john!`
* `GET /users` => `List of users`
* `POST /users` => `A json response`

## Route groups

Route groups are good to organize routes into logical groups. [Read more](http://www.slimframework.com/docs/v4/objects/routing.html#route-groups)

