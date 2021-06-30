---
layout: default
title: Configuration
parent: Getting Started
nav_order: 2
---

# Configuration

## Application configuration 

The directory for all configuration files is: `config/`

The file `config/settings.php` is the main configuration file and combines 
the default settings with environment specific settings. 

The configuration files are loaded in this order:

1. Load `config/defaults.php` with all default settings.

2. Load `config/env.php` or `config/../../env.php` and include the environment specific configuration file, e.g. `config/development.php`

3. If the constant `APP_ENV` is defined, load the environment specific file. 
This is only used to apply the phpunit test settings.

## Different Environments, different Configuration Files

A typical application begins with three environments: dev, prod and test. 
Each environment represents a way to execute the same codebase with 
different configuration. It should be no surprise then that each environment 
loads its own individual configuration files. 
These different files are organized by environment:

* for the `dev` environment: `config/local.dev.php`
* for the `prod` environment: `config/local.prod.php`
* for the `test` environment: `config/local.test.php`

## Environment configuration

You may be familiar with the concept of `.env` files. 
However, `.env` files should be considered as harmful because:

* People could put the file `.env` file into a public accessible directory.
* A public accessible `.env` file can be [indexed by search engines](https://www.google.com/search?q=DB_USERNAME+filetype%3Aenv).
* `.env` files are not native and much slower than PHP files.
* `.env` files are not intended to run on a production server. Many developers do it anyway.
* `vlucas/phpdotenv` is an unnecessary dependency and buggy in multi-thread PHP [(read more)](https://github.com/craftcms/cms/issues/3631)

Even **environment variables** should be considering as harmful because:

* A third-party server tool or any system-service could send a crash-report with all environment variables to foreign servers.
* Any other tool on your server could read the environment variables.
* Incorrectly configured servers could log the environment variables or even send them as error message to the browser. 
* Using `getenv()` and `putenv()` is strongly discouraged due to the fact that these functions are not thread safe.

The method of getting these values is using the `$_ENV` and `$_SERVER` super-global not the `getenv()` function.

For security (and performance) reasons, all secret environment variables 
are better stored in a file called: **`env.php`**.

Create a copy of the file `config/env.example.php` and rename it to
`config/env.php`

The `env.php` file is generally kept out of version control since it can contain sensitive API keys and passwords.
 
> **Never commit the env.php file to the version control system!**

Add the file `env.php` to your `.gitignore`, so that you don't accidentally commit it.

You also can (and should) use the `env.php` file on your testing, staging and production server.
In this case store the server specific `env.php` file one directory above the project root directory.
Storing the `env.php` file above the project directory simplifies deployment and ensures that the configuration is always in the right place and can be loaded at any time.

## Errors and logging

The directory for all log files is: `logs/`

The default settings are stored in `config/defaults.php`, `$settings['logger']`

## Read more

[Slim 4 - Laminas Config](https://odan.github.io/2021/03/21/slim4-laminas-config.html)
