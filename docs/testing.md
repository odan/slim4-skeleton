---
layout: default
title: Testing
nav_order: 8
---

# Testing

## Usage

The test directory is: `tests/` 

The fixture directory is: `tests/Fixture/`

To start all tests, run:

```
composer test
```

To start all tests with code coverage, run:

```
composer test:coverage
```

The code coverage output directory is: `build/coverage/`

## Unit Tests

Testing units in isolation of its dependencies.

Unit tests should test the behavior and not the implementation details of your classes.
Make sure that unit tests are running in-memory only, because they have to be very fast. 

## HTTP Tests

The `AppTestTrait` provides methods for making HTTP requests to your 
Slim application and examining the output. 

### Creating a request

Creating a `GET` request:

```php
$request = $this->createRequest('GET', '/users');
```

Creating a `POST` request:

```php
$request = $this->createRequest('POST', '/users');
```

Creating a JSON `application/json` request with payload:

```php
$request = $this->createJsonRequest('POST', '/users', ['name' => 'Sally']);
```

Creating a form `application/x-www-form-urlencoded` request with payload:

```php
$request = $this->createFormRequest('POST', '/users', ['name' => 'Sally']);
```

### Creating a query string

The [http_build_query](https://www.php.net/manual/en/function.http-build-query.php) can generate
URL-encoded query strings. Example:

```php
$params = [
    'limit' => 10,
];

$url = sprintf('/users?%s', http_build_query($params));
// $url is now: /users?limit=10

$request = $this->createRequest('GET', $url);
```

### Add BasicAuth to the request

```php
$request = $this->withHttpBasicAuth($request);
```

### Invoking a request

The Slim App `handle()` method traverses the application
middleware stack + actions handler and returns the Response object.

```php
$response = $this->app->handle($request);
``` 

Asserting the HTTP status code:

```php
$this->assertSame(200, $response->getStatusCode());
```

Asserting a JSON response:

```php
$this->assertJsonContentType($response);
```

Asserting JSON response data:

```php
$this->assertJsonData($response, [
    'user_id' => 1,
    'username' => 'admin',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
]);
```

You can find more examples in: `tests/TestCase/Action/`

## Read more

* [Testing with PHPUnit](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
