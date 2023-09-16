---
layout: default
title: Configuration
parent: Getting Started
nav_order: 2
---

# Configuration

## Configuration Directory

The directory for the configuration files is: `config/`

## Configuration Environments 

A typical application begins with three environments: dev, prod and test. 
Each environment represents a way to execute the same codebase with 
different configuration. Each environment 
loads its own individual configuration files. 

These different files are organized by environment:

* for the `dev` environment: `config/local.dev.php`
* for the `prod` environment: `config/local.prod.php`
* for the (phpunit) `test` environment: `config/local.test.php`

The file `config/settings.php` is the main configuration file and combines
the default settings with environment specific settings.

The configuration files are loaded in this order:

* Load default settings from: `config/defaults.php`

* If the environment variable `APP_ENV` is defined, 
load the environment specific file, e.g. `config/local.{env}.php`

* Load secret credentials (if file exists) from:
    * `config/env.php`
    * `config/../../env.php`

To switch the environment you can change the `APP_ENV` environment variable.

```php
$_ENV['APP_ENV'] = 'prod';
```

## Secret Credentials

For security reasons, all secret values 
are stored in a file called: **`env.php`**.

Create a copy of the file `config/env.example.php` and rename it to `config/env.php`

The `env.php` file is generally kept out of version control 
since it can contain sensitive API keys and passwords.
 
## Read more

* [Environments and Configuration](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
