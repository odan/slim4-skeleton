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
$this->assertJsonData([
    'user_id' => 1,
    'username' => 'admin',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
], $response);
```

You can find more examples in: `tests/TestCase/Action/`

## Database Testing

The `DatabaseTestTrait` provides methods
for all these stages of a database test:

* Import the database schema (table structure)
* Insert the fixtures (rows) required for the test.
* Execute the test 
* Verify the state of the tables
* Cleanup the tables for each new test

### Test fixtures

Insert multiple fixtures at once:

```php
use App\Test\Fixture\CustomerFixture;

$this->insertFixtures([CustomerFixture::class]);
```

Insert manual fixtures:

```php
$this->insertFixture('tablename', $row);
```

### Database asserts

Assert a number of rows in a given table:

```php
$this->assertTableRowCount(1, 'users');
```

Assert the given row exists:

```php
$this->assertTableRowExists('users', 1);
```

Assert that the given row does not exist:

```php
$this->assertTableRowNotExists('users', 1);
```

Assert row values:

```php
$this->assertTableRow($expected, 'users', 1);
```

Assert a specific set of row values:

```php
$this->assertTableRow($expected, 'users', 1, ['email', 'url']);
```

```php
$this->assertTableRow($expected, 'users', 1, array_keys($expected));
```

Assert a specific value in a given table, row and field:

```php
$this->assertTableRowValue('1', 'users', 1, 'id');
```

Read single value from table by id:

```php
$password = $this->getTableRowById('users', 1)['password'];
```

## Testing with Date and Time

To change the date and time for testing purposes, invoke the 
`Chronos::setTestNow` method within a test as follows:

```php
use Cake\Chronos\Chronos;

Chronos::setTestNow('2022-02-01 00:00:00');
```

## Mocking

When testing Slim applications, you may wish to "mock" certain aspects of your
application, so they are not actually executed during a test.
For example, when testing a service that needs a repository,
you may wish to mock the repository so that it's not actually
executed queries during the test.

Note: Mocking is not a good testing method, because you may
not test the code you actually deploy, and furthermore,
if you change the code, you will have to change the test as well.
The meaningfulness and maintainability of tests with a
mock is thus significantly lower compared to a test
that tests the entire code.

The `AppTestTrait` provides methods for mocking objects into the container.

Mocking methods:

```php
$this->mock(UserCreator::class)->method('createUser')->willReturn(1);
```

For better IDE  support you may better use the `mockMethod` helper:

```php
$this->mockMethod([UserReaderRepository::class, 'getUserById'])
    ->willReturn(['example' => 'data']);
```

## Read more

* [Testing with PHPUnit](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
