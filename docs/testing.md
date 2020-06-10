---
layout: default
title: Testing
nav_order: 15
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

## Mocking

When testing Slim applications, you may wish to "mock" certain aspects of your 
application so they are not actually executed during a test. 
For example, when testing a service that needs a repository, 
you may wish to mock the repository so that its not actually 
executed queries during the test.

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

## HTTP Tests

The `AppTestTrait` provides methods for making HTTP requests to your 
Slim application and examining the output. 

Creating a GET request:

```php
$request = $this->createRequest('GET', '/users/1');
```

Creating a POST request:

```php
$request = $this->createRequest('POST', '/users');
```

Creating a JSON (`application/json`) request with payload:

```php
$request = $this->createJsonRequest('POST', '/users', ['name' => 'Sally']);
```

Creating a form (`application/x-www-form-urlencoded`) request:

```php
$request = $this->createFormRequest('POST', '/users', ['name' => 'Sally']);
```

Make request and get the response. This method traverses the application
middleware stack and then returns the resultant Response object.

```php
$response = $this->app->handle($request);
``` 

Asserting the HTTP status code:

```php
$this->assertSame(200, $response->getStatusCode());
```

Asserting a JSON response:

```php
$this->assertJsonData($response, [
    'user_id' => 1,
    'username' => 'admin',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
]);
```

Take a look at the examples in: `tests/TestCase/Action/`

## Database Testing

The `DatabaseTestTrait` provides methods
for all these stages of a database test:

* Import the database schema (table structure)
* Insert the fixtures (rows) required for the test.
* Execute the test 
* Verify the state of the tables
* Cleanup the tables for each new test

Take a look at these examples:

* `tests/TestCase/Domain/User/Repository/UserCreatorRepositoryTest.php`

## Debugging Tests

To debug tests in [PhpStorm](https://www.jetbrains.com/phpstorm/), you have to mark the `tests/` directory as test sources root. 

* Open the project in PhpStorm
* Right click the directory `tests` 
* Select: `Mark directory as`
* Click `Test Sources Root`
* Set a breakpoint within a test method
* Right click `test`
* Click `Debug (tests) PHPUnit`
