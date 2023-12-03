---
layout: default
title: Security
nav_order: 5
---

# Security

## Basic Authentication

[BasicAuth](https://en.wikipedia.org/wiki/Basic_access_authentication) 
is an authentication scheme built into the HTTP protocol. 
As long as the client transmits its data over **HTTPS**, 
it's a secure **authentication** mechanism.  

```
Authorization: Basic YXBpLXVzZXI6c2VjcmV0
```

The [tuupola/slim-basic-auth](https://github.com/tuupola/slim-basic-auth) package implements HTTP Basic Authentication.

* [Basic Authentication](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)

## OAuth 2.0

For **authorization**, you could consider to use [OAuth 2.0](https://oauth.net/2/) in combination with a signed [JSON Web Token](https://oauth.net/2/jwt/).

The JWTs can be used as OAuth 2.0 [Bearer-Tokens](https://oauth.net/2/bearer-tokens/) to encode all relevant parts of an access token into the access token itself instead of having to store them in a database.

Please note: [OAuth 2.0 is not an authentication protocol](https://oauth.net/articles/authentication/).

Clients may use the **HTTP Basic authentication** scheme, as defined in [RFC2617](https://tools.ietf.org/html/rfc2617),
to authenticate with the server.

After successful authentication, the client sends its token within the `Authorization` request header:

```
Authorization: Bearer RsT5OjbzRn430zqMLgV3Ia
```

The [lcobucci/jwt](https://github.com/lcobucci/jwt) and 
[firebase/php-jwt](https://github.com/firebase/php-jwt) packages
are a very good tools to work with JSON Web Tokens.

* [Firebase JWT](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [Mezzio OAuth2 Server](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [JSON Web Token (JWT)](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Auth0 PHP SDK](https://auth0.com/docs/libraries/auth0-php)
* [Stop using JWT for sessions](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)
* [Swagger - OAuth 2.0](https://swagger.io/docs/specification/authentication/oauth2/)

## Cross-site Request Forgery (CSRF) Protection

Cross-site request forgery (CSRF) is a web security vulnerability 
that tricks a victim's browser into performing unwanted 
actions on a web application where the user is authenticated, 
without their knowledge or consent.

* [CSRF](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [Slim Framework CSRF Protection](https://github.com/slimphp/Slim-Csrf)

**SameSite Cookies** can be used for security purposes 
to prevent CSRF attacks, 
by controlling whether cookies are sent along with cross-site requests, 
thereby limiting the risk of third-party interference with 
the intended functioning of web applications.

* [SameSite Cookies](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [selective/samesite-cookie](https://github.com/selective-php/samesite-cookie)

## Cross-Origin Resource Sharing (CORS)

Cross-Origin Resource Sharing (CORS) is a security feature 
implemented by web browsers that controls how web pages 
in one domain can request resources from another domain, 
aiming to safely enable interactions between different origins.

* [Setting up CORS](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html)
* [CORS](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [middlewares/cors](https://github.com/middlewares/cors)

## Cross Site Scripting (XSS) Prevention

Cross-site Scripting (XSS) is a client-side code injection attack. 
The attacker aims to execute malicious scripts in a web browser of the 
victim by including malicious code in a legitimate web page or web application.

To prevent XSS you can use an Auto-Escaping Template System such as Twig
or by using libraries that are specifically designed to sanitize HTML input:

* [laminas/laminas-escaper](https://github.com/laminas/laminas-escaper)
* [Cross Site Scripting Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
* [Cross-site Scripting (XSS)](https://www.acunetix.com/websitesecurity/cross-site-scripting/)
* [XSS - Cross-site Scripting Protection](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)

## More Resources

* [Mezzio OAuth2 Server](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [PHP Middleware](https://github.com/php-middleware)
* [middlewares/firewall](https://github.com/middlewares/firewall)
* [PSR-15 HTTP Middlewares](https://github.com/middlewares)
* [Shieldon - Web Application Firewall](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Spam Protection](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Symfony Rate Limiter](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [XSS - Cross-site Scripting Protection](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
