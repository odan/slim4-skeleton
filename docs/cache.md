---
layout: default
title: Cache
parent: Advanced
---

# Cache

## Introduction

Some data retrieval or processing tasks performed by your 
application could be CPU intensive or take several seconds to complete. 
When this is the case, it is common to cache the retrieved data for a 
time, so it can be retrieved quickly on subsequent requests for the same data. 

## HTTP Caching

Slim uses the optional standalone [slimphp/Slim-HttpCache](https://github.com/slimphp/Slim-HttpCache) PHP component
for HTTP caching. You can use this component to create and return responses that
contain `Cache`, `Expires`, `ETag`, and `Last-Modified` headers that control
when and how long application output is retained by client-side caches. You may have to set your php.ini setting "session.cache_limiter" to an empty string in order to get this working without interferences.

* [HTTP Caching](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)

## Storage Caching

The cached data is usually stored in a very fast data store such as Memcached or Redis.
Thankfully, the [laminas/laminas-cache](https://docs.laminas.dev/laminas-cache/) and 
[symfony/cache](https://symfony.com/doc/current/components/cache.html)
components provides a [PSR-6](https://www.php-fig.org/psr/psr-6/) and
[PSR-16](https://www.php-fig.org/psr/psr-16/) compliant API for various cache backends, allowing you to take advantage
of their blazing fast data retrieval and speed up your web application.

* [Symfony Cache](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [Redis](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Memcached](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
