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
$app->get('/users', \App\Action\User\UserIndexAction::class);
```

## Route groups

Route groups are good to organize routes into logical groups. [Read more](http://www.slimframework.com/docs/v4/objects/routing.html#route-groups)

## VSCode Snippet

[Snippets in Visual Studio Code - Create your own snippets](https://code.visualstudio.com/docs/editor/userdefinedsnippets#_create-your-own-snippets).

Should be added to file `Code/User/snippets/php.json`.

For quick access start typing `$app` then pick snippet from dropdown.

```json
    "slim4 skeleton route": {
        "prefix": [
            "$app->get",
            "$group->get"
        ],
        "body": [
            "// Route for /$1",
            "\\$${2|app,group|}->${3|get,post,put,patch,delete|}('/$1', \\App\\Action\\\\$4::class)->setName('${1/[^A-z^0-9^-]/:downcase/g}');"
        ],
        "description": "Route declaration for Slim4 skeleton"
    },
```
