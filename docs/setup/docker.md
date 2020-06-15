---
layout: default
title: Docker 
parent: Installation
nav_order: 2
---

# Docker Development Environment

## Requirements

* The latest [Docker](https://www.docker.com/) version

## Installation

Create a new project:

```
composer create-project odan/slim4-skeleton my-app
```

To build the webserver, run:

```
docker-compose build
```

To start the webserver, run:

```
docker-compose up
```

## Configuration

For development and for production you can use the `env.php` for the secret passwords, 
private keys and so on.

Copy the file: `config/env.example.php` to `config/env.php`.

```bash
cp config/env.example.php config/env.php
```

To connect to the internal MySQL database change the configuration in `config/env.php` to this:

**Example**

```php
$settings['db']['host'] = getenv('MYSQL_HOST');
$settings['db']['database'] = getenv('MYSQL_DATABASE');
$settings['db']['username'] = getenv('MYSQL_USER');
$settings['db']['password'] = getenv('MYSQL_PASSWORD');
```

**Warning**: The `getenv` functon is not thread safe. You may 
look for environment variables in the `$_SERVER` super global instead.

If you want to connect from a container to a (MySQL) service on the host you can 
use `host.docker.internal` to reference the host. 
[Read more](https://docs.docker.com/docker-for-windows/networking/#use-cases-and-workarounds).

**Example**

```php
$settings['db']['host'] = 'host.docker.internal';
$settings['db']['port'] = '3306';
$settings['db']['username'] = 'root';
$settings['db']['password'] = 'secret';
```

To determine wheter the process in running in a docker container,
you can check the `DOCKER` environment variable, e.g.:

```php
if (getenv('DOCKER') === '1') {
    // Running in a docker container
} else {
    // Load other settings
}
```

Then navigate to `http://localhost:8080` or `http://127.0.0.0:8080` to open the web application.

## Debugging in PhpStorm

* Start the docker container with `docker-compose up`
* Open PhpStorm
* Enable the Xdebug option: "Can accept external connections". See [screenshot](https://user-images.githubusercontent.com/781074/83182499-ba9e7f00-a126-11ea-88c0-f28d0cbff260.png)
* Start the Xdebug listener
* Set a debugger breakpoint
* Navigate to `http://localhost:8080`
* Use the [PhpStorm bookmarklets generator](https://www.jetbrains.com/phpstorm/marklets/) to set the Xdebug cookie.
* Navigate to the url you want to debug
