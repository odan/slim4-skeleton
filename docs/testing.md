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

``` bash
$ composer test
```

To start all tests with code coverage, run:

``` bash
$ composer test-coverage
```

The code coverage output directory is: `build/coverage/`

## Overview

You can write several kinds of tests:

* **Unit tests**: Testing units in isolation of its dependencies. Everything should run in-memory, very fast.
* **Integration tests**: Database tests (e.g. Repositories), quite slow.
* **Acceptance tests**: HTTP and API tests.

## Unit Tests

Unit tests should test the behavior and not the implementation details of your (service) classes.
Make sure that unit tests are running in-memory only, because they have to be very fast. 

### Mocking the database

For the sake of real unit-tests (and performance), it's recommend to mock the Repository interface or methods.

This will allow you to write real unit tests without any database interactions. 

Of course you still can (and should) implement [Integration Tests](#integration-tests) 
with a real testing database.

You can use the [PHPUnit mocking functionality](https://phpunit.de/manual/current/en/test-doubles.html)
to create mocks for the repository interface or methods. This will allow you to create custom result sets per test,
without touching the database and without extra mock classes.

Please take a look at this example to see how to mock out the complete database:

* `tests/TestCase/Domain/User/Service/UserGeneratorTest.php`

## Integration Tests

Everything is ready to run real database tests.

Take a look at these examples:

* `tests/TestCase/Domain/User/Repository/UserCreatorRepositoryTest.php`

## Acceptance Tests

Everything is prepared to run mocked HTTP tests. 

Have a look at these examples: `tests/TestCase/Action/`

**Tip:** Try out [Codeception](https://codeception.com/) for even more advanced acceptance tests.

### API test with curl

Under linux you may have to install curl to make HTTP requests to your API:

```bash
curl -X POST -H "Content-Type: application/json" -d '{"key1":"value1","key2":"value2"}' http://localhost:8080
```

Windows users have to install [Curl for Windows](https://curl.haxx.se/windows/)
and should escape `"` with `\"` in the console.

```bash
curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost:8080
```

## Debugging Unit Tests

To debug tests in [PhpStorm](https://www.jetbrains.com/phpstorm/), you have to mark the `tests/` directory as test sources root. 

* Open the project in PhpStorm
* Right click the directory `tests` 
* Select: `Mark directory as`
* Click `Test Sources Root`
* Set a breakpoint within a test method
* Right click `test`
* Click `Debug (tests) PHPUnit`
