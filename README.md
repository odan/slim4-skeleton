# Slim 4 Skeleton for Apache

This is a simple web application skeleton project that uses the [Slim 4 Framework](https://www.slimframework.com/):

* [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) as unit testing framework
* [nyholm/psr7](https://github.com/nyholm/psr7) as super lightweight PSR-7 implementation
* [league/container](https://github.com/thephpleague/container) as dependency injection container (PSR-11)
* [monolog/monolog](https://github.com/monolog/monolog) as logger (PSR-3)
* [twig/twig](https://github.com/twigphp/Twig) as template engine
* [odan/twig-assets](https://github.com/odan/twig-assets) as JavaScript / CSS assets manager 

## Requirements

* PHP 7.2+
* Composer

## Installation

* Download and extract the ZIP file: [master.zip](https://github.com/odan/slim4-hello-world/archive/master.zip)
* Run: `composer update`
* Upload all files to the webserver
* Open the website
* You should see a message: `Hello, World!`

## Routes

* `GET /` => `Hello, World!`
* `GET /hello/john` => `Hello, john!`
* `GET /time` => `Current time: ...`
* `POST /users` => `json response`

## Tests

Start API integration tests with:

```
composer test
```

Start API integration tests with full coverage report:

```
composer test-coverage
```

## License

* MIT
