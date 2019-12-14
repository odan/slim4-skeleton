---
layout: default
title: Security
nav_order: 13
---

# Security

## Authentication

This skeleton uses [sessions](https://www.php.net/manual/en/book.session.php) (cookies) to handle the logged-in user.

You could also use the [OAuth 2.0](https://oauth.net/2/) authentication standard in combination with a 
[Bearer-Token](https://oauth.net/2/bearer-tokens/) or a [JSON Web Token](https://oauth.net/2/jwt/).

[lcobucci/jwt](https://github.com/lcobucci/jwt) is a good library to work with JSON Web Token (JWT) 
and JSON Web Signature based on RFC 7519.

Please note that a **logout** functionality with tokens is not feasible without giving 
up the **stateless** principle.

It's up to you how you configure the routes and their individual authentication.

Read more: 

* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Slim 4 - OAuth 2.0 and JSON Web Token (JWT) Setup](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)

## Authorization

*This section is under construction!*

Determine the logged-in user ID:

```php
$userId = $this->auth->getUserId();
```

Checking the user role (permission group):

```php
$isAdmin = $this->auth->hasRole(UserRole::ROLE_ADMIN);
```
