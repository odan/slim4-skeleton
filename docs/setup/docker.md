---
layout: default
title: Docker 
parent: Installation
nav_order: 2
---

# Docker Development Environment

## Requirements

* The latest [Docker](https://www.docker.com/) version

## Configuration

Use the `docker-compose.yml` and `Dockerfile` to configure and run the application.

For development and for production you can use the `env.php` for the secret passwords, 
private keys etc...

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

If you want to connect from a container to the service in the same container, 
you can read the environment variables using `env(...)`:

**Example**

```php
$settings['db']['host'] = env('MYSQL_HOST');
$settings['db']['database'] = env('MYSQL_DATABASE');
$settings['db']['username'] = env('MYSQL_USER');
$settings['db']['password'] = env('MYSQL_PASSWORD');
```

To determine wheter the process in running in a docker container,
you can check the `DOCKER` environment variable, e.g.:

```php
if (env('DOCKER') === '1') {
    // Running in a docker container
}
```

## Usage

To build the server, run:

```
docker-compose build
```

To start the webserver, run:

```
docker-compose up
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
