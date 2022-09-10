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

The [tuupola/slim-basic-auth](https://github.com/tuupola/slim-basic-auth) package
implements HTTP Basic Authentication. It was originally developed 
for Slim but can be used with all frameworks using 
PSR-7 or PSR-15 style middlewares.

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

**Read more:** 

* [Slim 4 - Firebase JWT](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [Slim 4 - Mezzio OAuth2 Server](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [Slim 4 - JSON Web Token (JWT)](https://ko-fi.com/s/5f182b4b22) (eBook)
* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Auth0 PHP SDK](https://auth0.com/docs/libraries/auth0-php)
* [Stop using JWT for sessions](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)
* [Swagger - OAuth 2.0](https://swagger.io/docs/specification/authentication/oauth2/)

## SameSite Cookies

* [Slim 4 - SameSite Cookies](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [selective/samesite-cookie](https://github.com/selective-php/samesite-cookie)

## CSRF protection

* [Slim 4 - CSRF](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [Slim Framework CSRF Protection](https://github.com/slimphp/Slim-Csrf)

## Cross-Origin Resource Sharing (CORS)

* [Setting up CORS](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html)
* [Slim 4 - CORS](https://ko-fi.com/s/5f182b4b22) (eBook)
* [middlewares/cors](https://github.com/middlewares/cors)

## Cross Site Scripting Prevention

Cross-site Scripting (XSS) is a client-side code injection attack. 
The attacker aims to execute malicious scripts in a web browser of the 
victim by including malicious code in a legitimate web page or web application.

To prevent XSS you can use an Auto-Escaping Template System such as Twig
or by using libraries that are specifically designed to sanitize HTML input:

* [laminas/laminas-escaper](https://github.com/laminas/laminas-escaper)
* [Cross Site Scripting Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
* [Cross-site Scripting (XSS)](https://www.acunetix.com/websitesecurity/cross-site-scripting/)

## More Resources

* [Slim 4 - Spam Protection](https://ko-fi.com/s/5f182b4b22) (eBook)
* [middlewares/firewall](https://github.com/middlewares/firewall)
* [PSR-15 HTTP Middlewares](https://github.com/middlewares)
* [PHP Middleware](https://github.com/php-middleware)
