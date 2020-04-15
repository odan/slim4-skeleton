<h1 align="center">
  <img src="https://user-images.githubusercontent.com/781074/67567104-9fe7d000-f729-11e9-8a2d-0c7286475aac.png">
</h1>

<h3 align="center">Slim 4 Skeleton</h3>

<div align="center">

  [![Latest Version on Packagist](https://img.shields.io/github/release/odan/slim4-skeleton.svg)](https://packagist.org/packages/odan/slim4-skeleton)
  [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
  [![Build Status](https://github.com/odan/slim4-skeleton/workflows/PHP/badge.svg)](https://github.com/odan/slim4-skeleton/actions)
  [![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/odan/slim4-skeleton.svg)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/code-structure)
  [![Quality Score](https://img.shields.io/scrutinizer/quality/g/odan/slim4-skeleton.svg)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/?branch=master)
  [![Total Downloads](https://img.shields.io/packagist/dt/odan/slim4-skeleton.svg)](https://packagist.org/packages/odan/slim4-skeleton/stats)

</div>

This is a skeleton to quickly set up a new [Slim 4](https://www.slimframework.com/) application.

**[Donate](https://odan.github.io/donate.html)**

## Requirements

* PHP 7.2+
* Apache (with mod_rewrite)
* Composer (only for development)
* [NPM](https://nodejs.org/en/download/) (for webpack)

#### Recommended

* MySQL 5.7+, 8.x
* [Apache ant](https://ant.apache.org/bindownload.cgi) to create deployment artifacts (build)

## Features

This project is based on best practice and industry standards:

* HTTP message interfaces (PSR-7)
* HTTP Server Request Handlers, Middleware (PSR-15)
* HTTP factories (PSR-17)
* HTTP router and dispatcher (Slim)
* Dependency injection container (PSR-11)
* Modern coding style (PSR-1, PSR-12)
* PHPDoc standard (PSR-5, PSR-19)
* Autoloading (PSR-4)
* Logging (PSR-3)
* [Standard PHP package skeleton](https://github.com/php-pds/skeleton)
* Single action controllers ([ADR](https://github.com/pmjones/adr/blob/master/ADR.md))
* Translations (Symfony)
* Sessions
* Database Query Builder
* Database Migrations ([Phinx](https://phinx.org/))
* Database Migrations Generator
* Date and time ([Chronos](https://github.com/cakephp/chronos))
* Console Commands (Symfony)
* Unit- and integrations tests (PHPUnit)
* Tested with [Github Actions](https://github.com/odan/slim4-skeleton/actions) and [Scrutinizer CI](https://scrutinizer-ci.com/)
* [PHPStan](https://github.com/phpstan/phpstan)
* Build and deployment scripts

## Frontend

* [Webpack](https://webpack.js.org/) (Assets bundler)
* [TypeScript](https://www.typescriptlang.org/) (Static type-checking)
* [Bootstrap](https://getbootstrap.com/) (Frontend component library)
* [jQuery](https://jquery.com/) (DOM manipulation, events, etc.)
* [DataTables.net](https://datatables.net/) (Advanced tables)
* [SweetAlert2](https://sweetalert2.github.io/) (Flexible modal window)
* [notifit 2](https://www.npmjs.com/package/notifit-js) (Notifications)
* Spinner (Loading indicator)
* CSS and JS minifier

## Documentation

Read the **[Documentation](https://odan.github.io/slim4-skeleton)**

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
