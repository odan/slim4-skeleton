---
layout: default
title: Middleware
nav_order: 7
---

# Middleware

In a Slim (PSR-7 / PSR-15) application you can add middleware handlers to all routes, 
to a specific route or to a group of routes. 

More details: [Slim 4 Routing](https://www.slimframework.com/docs/v4/objects/routing.html) 

## Global middleware

Some middleware handlers are already registered to ensure that the 
exception handling, and some security checks are enabled by default.

More details: [config/middleware.php](https://github.com/odan/slim4-skeleton/blob/master/config/middleware.php)

## Route specific middleware

You can also add custom middleware handler per route and/or a complete routing group. This makes
it easier to differentiate between public and protected areas, as well as api resources etc.

More details: [config/routes.php](https://github.com/odan/slim4-skeleton/blob/master/config/routes.php)
