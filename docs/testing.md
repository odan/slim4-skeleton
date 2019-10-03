## Testing

All tests are located in the `tests/` folder. To start the unit test run:

``` bash
$ composer test
```

or

``` bash
$ composer test-coverage
```

You can write several kinds of tests:

* **Unit tests**: Testing units in isolation of its dependencies. Everything should run in-memory, very fast.
* **Integration tests**: Database tests (e.g. Repositories), quite slow.
* **Acceptance tests**: HTTP and API tests, quite fast.

### Unit Tests

Unit tests should test the behavior and not the implementation details of your (service) classes.
Make sure that unit tests are running in-memory only, because they have to be very fast. 

#### Mocking the database

For the sake of real unit-tests and performance, we recommend mocking all Repository interfaces 
(no problem with phpunit) or create an memory based Repository that implements the
required Repository interface.

This will allow you to write real unit tests without any database interactions. 

Of course you still can (and should) implement [Integration Tests](#integration-tests) 
with a real testing database.

We are using the [PHPUnit mocking functionality](https://phpunit.de/manual/current/en/test-doubles.html)
to create mocks for the repository interface. This will allow you to create custom result sets per test,
without touching the database and without extra mock classes.

Please take a look at this example to see how to mock out the complete database:

* `tests/TestCase/Domain/User/UserListTest.php`

### Debugging Unit Tests

To debug tests with PhpStorm you must have to mark the directory `tests/` 
as the test root source.

* Open the project in PhpStorm
* Right click the directory `tests` 
* Select: `Mark directory as`
* Click `Test Sources Root`
* Set a breakpoint within a test method
* Right click `test`
* Click `Debug (tests) PHPUnit`

### Integration Tests

Everything is ready to run real database tests.

Please take a look at this example test:

* `tests/TestCase/Domain/User/UserRepositoryTest.php`

#### Fixtures

See: `tests/Fixture/`

todo: Add more description

#### Seeds

See: `resources/seeds/`

todo: Add more description

### Acceptance Tests

Everything is prepared to run mocked HTTP tests. 

You don't need external services like [Postman](https://www.getpostman.com/), 
because it's possible to simulate all requests yourself.

Please have a look at these sample tests in `tests/TestCase/Action` directory.

> Tip: Try out [Codeception](https://codeception.com/) for more advanced acceptance tests.

#### API test with curl

Under linux you have to install curl to make HTTP requests to your api:

```bash
curl -X POST -H "Content-Type: application/json" -d '{"key1":"value1","key2":"value2"}' http://localhost:8080
```

Windows users have to install [Curl for Windows](https://curl.haxx.se/windows/)
and should escape `"` with `\"` in the console.

```cmd
curl -X POST -H "Content-Type: application/json" -d {\"key1\":\"value1\"} http://localhost:8080
```

<hr>

Navigation: [Index](readme.md)
