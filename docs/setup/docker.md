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

*If you have only cloned the skeleton project, 
you have to install the dependencies manually:*

```
composer update
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

To load the docker environment variables, you can use the `$_ENV` and `$_SERVER` super-globals.

```php
$settings['db']['host'] = $_ENV['MYSQL_HOST'];
$settings['db']['database'] = $_ENV['MYSQL_DATABASE'];
$settings['db']['username'] = $_ENV['MYSQL_USER'];
$settings['db']['password'] = $_ENV['MYSQL_PASSWORD'];
```

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

To determine whether the process in running in a docker container,
you can check the `DOCKER` environment variable, e.g.:

```php
if (isset($_ENV['DOCKER'])) {
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

## SSH into a Docker container

* List all running containers to get the container id: `sudo docker ps`
* To get access and run commands in that Docker container, type the following: `sudo docker exec –it {container-id} /bin/bash`

## Installing Apache Ant

* [Log into the container with SSH](#ssh-into-a-docker-container)
* To install ant, run: 
  * `mkdir -p /usr/share/man/man1`
  * `apt-get install -y openjdk-11-jdk`
  * `apt-get install ant -y`
  
