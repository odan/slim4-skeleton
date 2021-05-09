<h1 align="center">
  <img src="https://user-images.githubusercontent.com/781074/67567104-9fe7d000-f729-11e9-8a2d-0c7286475aac.png">
</h1>

<h3 align="center">Slim 4 Skeleton</h3>

<div align="center">

  [![Latest Version on Packagist](https://img.shields.io/github/release/odan/slim4-skeleton.svg)](https://packagist.org/packages/odan/slim4-skeleton)
  [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
  [![Build Status](https://github.com/odan/slim4-skeleton/workflows/build/badge.svg)](https://github.com/odan/slim4-skeleton/actions)
  [![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/odan/slim4-skeleton.svg)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/code-structure)
  [![Quality Score](https://img.shields.io/scrutinizer/quality/g/odan/slim4-skeleton.svg)](https://scrutinizer-ci.com/g/odan/slim4-skeleton/?branch=master)
  [![Total Downloads](https://img.shields.io/packagist/dt/odan/slim4-skeleton.svg)](https://packagist.org/packages/odan/slim4-skeleton/stats)

This is a skeleton to quickly set up a new [Slim 4](https://www.slimframework.com/) application.

</div>

## Requirements

* PHP 7.4+ or 8.0+
* MySQL 5.7+ or MariaDB

#### Recommended

* Apache with mod_rewrite
* [Apache Ant](https://ant.apache.org/bindownload.cgi) to build deployment artifacts

## Installation

```
composer create-project odan/slim4-skeleton my-app
```

Read more: **[Documentation](https://odan.github.io/slim4-skeleton/installation.html)**

## Features

This project is based on best practices and industry standards:

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
* Input validation
* SQL Query Builder
* Database migrations
* Immutable date and time ([Chronos](https://github.com/cakephp/chronos))
* Unit- and integration tests (PHPUnit)
* Console Commands
* Tested with [Github Actions](https://github.com/odan/slim4-skeleton/actions) and [Scrutinizer CI](https://scrutinizer-ci.com/)
* [PHPStan](https://github.com/phpstan/phpstan) (Level: max)
* Build and deployment scripts
* Docker container with Xdebug support
* Swagger OpenAPI documentation

## Screenshot

![screely-1611483778132](https://user-images.githubusercontent.com/781074/105627322-940c2180-5e36-11eb-9941-fa75bb00e4c8.png)

## Usage

You can clone this project to modify it as you wish to create awesome API's and web applications. 

*This project is just a skeleton-project and not a "framework".*

## Support

* [Issues](https://github.com/odan/slim4-skeleton/issues)
* [Blog](https://odan.github.io/)  
* [Donate](https://odan.github.io/donate.html) for this project.

## Contributing

Please create an [issue](https://github.com/odan/slim4-skeleton/issues) first, so we can discuss it in advance.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
