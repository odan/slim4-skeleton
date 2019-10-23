# Slim 4 Skeleton

[![Latest Version on Packagist](https://img.shields.io/github/release/odan/slim4-skeleton.svg?style=flat-square)](https://packagist.org/packages/odan/slim4-skeleton)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/odan/slim4-skeleton/master.svg?style=flat-square)](https://travis-ci.org/odan/slim4-skeleton)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/odan/slim4-skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/odan/slim4-skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/slim4-skeleton.svg?style=flat-square)](https://packagist.org/packages/odan/slim4-skeleton/stats)

Use this skeleton application to quickly setup and start working on a new [Slim 4 Framework](https://www.slimframework.com/) application.

## Requirements

* PHP 7.1+
* Apache with mod_rewrite
* Composer (only for development)

#### Recommended

* MySQL 5.7+
* [NPM](https://nodejs.org/en/download/) for webpack

## Features

This project comes configured with:

* Modern coding style (PSR-1, PSR-2, PSR-12)
* PHPDoc Standard (PSR-5, PSR-19)
* Class Autoloader (PSR-4)
* HTTP request and response (PSR-7)
* HTTP Server Request Handlers, Middleware (PSR-15)
* HTTP Factories (PSR-17)
* Dependency injection container (PSR-11)
* Routing
* Single action controllers ([ADR](https://github.com/pmjones/adr/blob/master/ADR.md))
* Logging (PSR-3)
* Translations
* Sessions and Cookies (todo)
* Authentication and Authorization (todo)
* Database Query Builder
* Database Migrations (Phinx)
* Database Migrations Generator
* Date and time (Chronos)
* Console Commands (Symfony)
* Unit testing (PHPUnit)
* Continuous integration

### Packages

This project also uses the following packages:

* [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) as unit testing framework
* [slim/psr7](https://github.com/slimphp/Slim-Psr7) as super lightweight PSR-7 implementation
* [monolog/monolog](https://github.com/monolog/monolog) as logger (PSR-3)
* [slim/twig-view](https://github.com/slimphp/Twig-View) as template engine
* [php-di/php-di](https://github.com/PHP-DI/PHP-DI) as container implementation (PSR-11)
* [symfony/translation](https://github.com/symfony/translation) as translator
* [odan/twig-translation](https://github.com/odan/twig-translation) as Twig translator extension
* [Webpack](https://webpack.js.org/) to bundle your assets

### Continuous integration

* Unit- and integrations tests
* Tested on Travis CI and Scrutinizer CI
* Code style checker and fixer (PSR-2, PSR-12)
* PHPStan (level=max)
* Deployment script

## Documentation

* Read the **[Documentation](https://odan.github.io/slim4-skeleton)**

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
