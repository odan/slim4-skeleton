# Slim 4 Skeleton for Apache

[![Latest Version on Packagist](https://img.shields.io/github/release/odan/slim4-skeleton.svg?style=flat-square)](https://packagist.org/packages/odan/slim4-skeleton)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/odan/slim4-skeleton/master.svg?style=flat-square)](https://travis-ci.org/odan/slim4-skeleton)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/odan/slim4-skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/odan/slim4-skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/slim4-skeleton.svg?style=flat-square)](https://packagist.org/packages/odan/slim4-skeleton/stats)

## Features

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

* Download and extract the ZIP file: [master.zip](https://github.com/odan/slim4-skeleton/archive/master.zip)
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

Start unit- and API integration tests with:

```
composer test
```

Start unit- and API integration tests + full coverage report with:

```
composer test-coverage
```

The code coverage report (xml and html) output directory is: `build/coverage`

## License

* MIT
