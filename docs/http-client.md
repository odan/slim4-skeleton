---
layout: default
title: HTTP Client
parent: Advanced
---

# HTTP Client

## Introduction

The Guzzle HTTP client provides an API around the cURL and PHP's stream wrapper
allowing you to quickly make outgoing HTTP requests to communicate with
other web applications.

Before getting started, you should ensure that you have installed 
the Guzzle package as a dependency of your application. 

You may install it via Composer:

```
composer require guzzlehttp/guzzle
```

## Usage

```php
use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://httpbin.org/',
    'timeout'  => 10,
]);

// Send a request to https://httpbin.org/anything
$response = $client->request('GET', 'anything');
```

**Read more**

* [Guzzle Documentation](https://docs.guzzlephp.org/en/stable/quickstart.html)
* [Guzzle Client Example](https://odan.github.io/2021/01/16/slim4-spam-protection.html)
