---
layout: default
title: Security
nav_order: 13
---

# Security

## Session

This skeleton uses [sessions](https://www.php.net/manual/en/book.session.php) (cookies) to store the logged-in user.
If you have to add API routes, you may use a [OAuth2 Bearer-Token](https://oauth.net/2/bearer-tokens/) or [JSON Web Token](https://oauth.net/2/jwt/) instead.

## Authentication

The authentication depends on the defined routes and the attached middleware.
You can add routing groups with Sessions and/or OAuth2 authentication. 
It's up to you how you configure the routes and their individual authentication.

## Authorization

*This section is under construction!*

To check user permissions, the Actions controller contains an `Auth` object.

Determine the logged-in user ID::

```php
$userId = $this->auth->getUserId();
```

Checking the user role (permission group):

```php
$isAdmin = $this->auth->hasRole(UserRole::ROLE_ADMIN);
```
