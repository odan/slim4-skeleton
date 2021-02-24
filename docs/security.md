---
layout: default
title: Security
nav_order: 5
---

# Security

## Basic Authentication

This API skeleton uses [Basic authentication](https://en.wikipedia.org/wiki/Basic_access_authentication).

BasicAuth is an authentication scheme built into the HTTP protocol. 
As long as the client transmits its data over **HTTPS**, 
it's a secure **authentication** mechanism.  

```
Authorization: Basic YXBpLXVzZXI6c2VjcmV0
```

The default API credentials are: `api-admin / secret` and `api-user / secret`.
To set up the users, copy the example file from `config/env.example.php` to `config/env.php`
and change the user credentials as desired. Read more: [Installation](installation.md)

Please note that the API credentials are not the same as the users 
in the example "users" database table.

**Read more:**

* [Swagger - Basic authentication](https://swagger.io/docs/specification/authentication/basic-authentication/)

## OAuth 2.0

For **authorization** you could consider to use [OAuth 2.0](https://oauth.net/2/) in combination with a signed [JSON Web Token](https://oauth.net/2/jwt/).

The JWTs can be used as OAuth 2.0 [Bearer-Tokens](https://oauth.net/2/bearer-tokens/) to encode all relevant parts of an access token into the access token itself instead of having to store them in a database.

Please note: [OAuth 2.0 is not an authentication protocol](https://oauth.net/articles/authentication/).

Clients may use the **HTTP Basic authentication** scheme, as defined in [RFC2617](https://tools.ietf.org/html/rfc2617),
to authenticate with the server.

After successful authentication, the client sends its token within the `Authorization` request header:

```
Authorization: Bearer RsT5OjbzRn430zqMLgV3Ia
```

[lcobucci/jwt](https://github.com/lcobucci/jwt) is a good library to work with JSON Web Token (JWT) 
and JSON Web Signature based on RFC 7519.

**Read more:** 

* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Auth0 PHP SDK](https://auth0.com/docs/libraries/auth0-php)
* [Slim 4 - OAuth 2.0 and JSON Web Token (JWT) Setup](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)
* [Stop using JWT for sessions](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)
* [Swagger - OAuth 2.0](https://swagger.io/docs/specification/authentication/oauth2/)

## CSRF protection

* [Slim Framework CSRF Protection](https://github.com/slimphp/Slim-Csrf)

## SameSite Cookies

* [selective/samesite-cookie](https://github.com/selective-php/samesite-cookie)

## Cross-Origin Resource Sharing (CORS)

* [Setting up CORS](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html)
* [Slim 4 - CORS](https://odan.github.io/2019/11/24/slim4-cors.html)
* [middlewares/cors](https://github.com/middlewares/cors)

## Cross Site Scripting Prevention

Cross-site Scripting (XSS) is a client-side code injection attack. 
The attacker aims to execute malicious scripts in a web browser of the 
victim by including malicious code in a legitimate web page or web application.

To prevent XSS you can use an Auto-Escaping Template System such as Twig
or by using libraries that are specifically designed to sanitize HTML input:

* [laminas/laminas-escaper](https://github.com/laminas/laminas-escaper)

**Read more**

* [Cross Site Scripting Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
* [Cross-site Scripting (XSS)](https://www.acunetix.com/websitesecurity/cross-site-scripting/)

## HTTPS / SSL

* [Slim 4 - HTTPS Middleware](https://odan.github.io/2020/04/07/slim4-https-middleware.html)
* [middlewares/https](https://github.com/middlewares/https)

## Spam Protection

* [Slim 4 - Spam Protection](https://odan.github.io/2021/01/16/slim4-spam-protection.html)

## IP Filter

* [middlewares/firewall](https://github.com/middlewares/firewall)

## More Resources

* [PSR-15 HTTP Middlewares](https://github.com/middlewares)
* [PHP Middleware](https://github.com/php-middleware)
