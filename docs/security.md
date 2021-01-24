---
layout: default
title: Security
nav_order: 13
---

# Security

## Authentication

This API skeleton uses [Basic authentication](https://en.wikipedia.org/wiki/Basic_access_authentication).

BasicAuth is an authentication scheme built into the HTTP protocol. 
As long as the client transmits its data over **HTTPS**, 
it's a secure authentication mechanism.  

```
Authorization: Basic ZGVtbzpwQDU1dzByZA==
```

You could also consider to use [OAuth 2.0](https://oauth.net/2/) in combination with a signed [JSON Web Token](https://oauth.net/2/jwt/).

The JWTs can be used as OAuth 2.0 [Bearer-Tokens](https://oauth.net/2/bearer-tokens/) to encode all relevant parts of an access token into the access token itself instead of having to store them in a database.

Please note: [OAuth 2.0 is not an authentication protocol](https://oauth.net/articles/authentication/).

Clients may use the HTTP Basic authentication scheme, as defined in [RFC2617](https://tools.ietf.org/html/rfc2617),
to authenticate with the server.

After successful authentication, the client sends its token within the `Authorization` request header:

```
Authorization: Bearer RsT5OjbzRn430zqMLgV3Ia
```

[lcobucci/jwt](https://github.com/lcobucci/jwt) is a good library to work with JSON Web Token (JWT) 
and JSON Web Signature based on RFC 7519.

**Read more:** 

* [Swagger - Basic authentication](https://swagger.io/docs/specification/authentication/basic-authentication/)
* [Swagger - OAuth 2.0](https://swagger.io/docs/specification/authentication/oauth2/)
* [OAuth Libraries for PHP](https://oauth.net/code/php/)
* [Slim 4 - OAuth 2.0 and JSON Web Token (JWT) Setup](https://odan.github.io/2019/12/02/slim4-oauth2-jwt.html)
* [Stop using JWT for sessions](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)
