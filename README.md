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
* Composer

#### Recommended

* [NPM](https://nodejs.org/en/download/) for webpack

### Packages

This project also uses the following packages:

* [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) as unit testing framework
* [slim/psr7](https://github.com/slimphp/Slim-Psr7) as super lightweight PSR-7 implementation
* [monolog/monolog](https://github.com/monolog/monolog) as logger (PSR-3)
* [slim/twig-view](https://github.com/slimphp/Twig-View) as template engine
* [league/container](https://github.com/thephpleague/container) as container implementation (PSR-11)
* [symfony/translation](https://github.com/symfony/translation) as translator
* [odan/twig-translation](https://github.com/odan/twig-translation) as Twig translator extension
* [Webpack](https://webpack.js.org/) to bundle your assets

### Continous integration

* Unit- and integrations tests
* Tested on Travis CI and Scrutinizer CI
* Code style checker and fixer (PSR-2, PSR-12)
* PHPStan (level=max)

## Installation

Run this command from the directory in which you want to install your new Slim Framework application.

```bash
composer create-project odan/slim4-skeleton {my-app-name}
```

Replace `{my-app-name}` with the desired directory name for your new application. You'll want to:

* Ensure `logs/` and `tmp/` is web writable.
* Open the app url
* You should see a message: `Hello, World!`

## Download

* You can also download the latest version as ZIP file: [master.zip](https://github.com/odan/slim4-skeleton/archive/master.zip)

## Routes

* `GET /` => `Hello, World!`
* `GET /hello/john` => `Hello, john!`
* `GET /users` => `List of users`
* `POST /users` => `A json response`

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

## Assets

To compile all assets, run:

```
npx webpack
```

To compile and minify all assets, run:

```
npx webpack --mode=production
```

To start frontend tests, run:

```
npm run test
```

To start frontend tests with code coverage, run:

```
npm run test:coverage
```

## Documentation

The documentation of this demo application can be found here: [Documentation](https://odan.github.io/slim4-skeleton)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
