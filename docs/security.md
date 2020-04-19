---
layout: default
title: Security
nav_order: 13
---

# Security

## Authentication

This skeleton uses [sessions](https://www.php.net/manual/en/book.session.php) (cookies) to handle the logged-in user.

For API's you should consider other options:
 
[Basic authentication](https://swagger.io/docs/specification/authentication/basic-authentication/) is a simple authentication scheme built into the HTTP protocol. 
As long as the client transmits the data over HTTPS, it's a secure authentication mechanism.  

```
Authorization: Basic ZGVtbzpwQDU1dzByZA==
```

You could also consider to use the [OAuth 2.0](https://oauth.net/2/) authentication standard in combination with a 
[Bearer-Token](https://oauth.net/2/bearer-tokens/) or a [JSON Web Token](https://oauth.net/2/jwt/).
[OAuth 2.0](https://swagger.io/docs/specification/authentication/oauth2/) is an authorization protocol to protect server resources without sharing their credentials.
For that purpose, an OAuth 2.0 server [issues access tokens](https://www.oauth.com/oauth2-servers/making-authenticated-requests/)
that the client applications can use to access protected resources on behalf of the resource owner.

```
Authorization: Bearer RsT5OjbzRn430zqMLgV3Ia"
```

[lcobucci/jwt](https://github.com/lcobucci/jwt) is a good library to work with JSON Web Token (JWT) 
and JSON Web Signature based on RFC 7519.

Note that a **logout** functionality with tokens is not feasible without giving up the **stateless** principle.
So please don't use JWT for session management or to avoid server-side storage for sessions. 

It's up to you how you configure the routes and their individual authentication.

**Read more:** 

* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Slim 4 - OAuth 2.0 and JSON Web Token (JWT) Setup](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)
* [Stop using JWT for sessions](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)
