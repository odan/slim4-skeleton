---
layout: default
title: Configuration
nav_order: 4
---

# Configuration

## Application configuration 

All configuration files are stored in the `config/` directory.

The `config/defaults.php` loads and combines multiple configuration files in this order:

1. Load `config/defaults.php` with all default settings.
2. Load `config/env.php` or `/../../env.php` with all environment specific settings.
3. If `APP_ENV` is defined, load the environment specific file.

## Environment configuration

You may be familiar with the concept of `.env` files. 
But `.env` files should be considering as harmful because: 

* People could put the file `.env` into a public available directory.
* A public available `.env` file will be indexed by search engines.
* `.env` files are not native and much slower then PHP files.
* `.env` files are not intended to run on a production server. Many developers do it anyway.
* `vlucas/phpdotenv` is a unnecessary dependency. PHP can do it better.
* `vlucas/phpdotenv` is buggy in multi-thread PHP [(read more)](https://github.com/craftcms/cms/issues/3631)

Even `environment variables` should be considering as dangerous because:

* A third-party tool or any system-service could send a crash-report with all environment variables to foreign servers.
* Any other tool on your server could read the environment variables.
* Incorrectly configured servers could log the environment variables or even send them as error message to the browser. 

For security (and performance) reasons, all secret environments variables 
are better stored in a file called: `env.php`.

Create a copy of the file `config/env.example.php` and rename it to
`config/env.php`

The `env.php` file is generally kept out of version control since it can contain sensitive API keys and passwords.
 
> Never commit the file `env.php` to the version control system!

Add the file `env.php` to your `.gitignore`, so that you don't accidentally commit it.

You also can (and should) use the `env.php` file on your testing / staging / production server.
In this case store the server specific `env.php` file one directory above the project root directory.
Storing the `env.php` file above the project directory simplifies deployment and ensures that the configuration is always in the right place and can be loaded at any time.
