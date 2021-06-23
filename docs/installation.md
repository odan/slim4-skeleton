---
layout: default
title: Installation
parent: Getting Started
nav_order: 1
---

# Installation

## Table of Contents

* [Composer](#composer)
* [Docker](#docker)
* [Vagrant](#vagrant)

## Composer

Run this command from the directory in which you want to install your new 
Slim Framework application.

**Step 1:** Create a new project:

```shell
composer create-project odan/slim4-skeleton my-app
```

**Step 2:** Set permissions *(Linux only)*

```bash
cd my-app

sudo chown -R www-data tmp/
sudo chown -R www-data logs/

sudo chmod -R 760 tmp/
sudo chmod -R 760 logs/

chmod +x bin/console.php
```

**Step 3:** Database setup

Create a new database for development

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

Create a new database for integration tests

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

**Step 4:** Configuration

Copy the file: `config/env.example.php` to `config/env.php`.

```bash
cp config/env.example.php config/env.php
```

Change the connection configuration in `config/env.php`:

```php
// Database
$settings['db']['database'] = 'test';
$settings['db']['username'] = 'root';
$settings['db']['password'] = '';
```

Run all the available migrations:

```shell
composer migration:migrate
```

**Step 5:** Run it

Open `http://localhost/{my-app}` in your browser

If you use the PHP internal web server, you can use this command:

```
cd {project-path/}
php -S localhost:8080 -t public
```

Then navigate to: `http://localhost:8080/`

In case you still have trouble with the setup,
you may try to upload the [Server Setup Checker](https://gist.github.com/odan/7fda1e4129cfd4a491ded5651fc32096)
to get an idea about the issue.

## Docker

This setup is intended to use Docker as development environment.

### Requirements

* The latest [Docker](https://www.docker.com/) version

### Installation

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

### Configuration

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

### Debugging in PhpStorm

* Start the docker container with `docker-compose up`
* Open PhpStorm
* Enable the Xdebug option: "Can accept external connections". See [screenshot](https://user-images.githubusercontent.com/781074/83182499-ba9e7f00-a126-11ea-88c0-f28d0cbff260.png)
* Start the Xdebug listener
* Set a debugger breakpoint
* Navigate to `http://localhost:8080`
* Use the [PhpStorm bookmarklets generator](https://www.jetbrains.com/phpstorm/marklets/) to set the Xdebug cookie.
* Navigate to the url you want to debug

### SSH into a Docker container

* List all running containers to get the container id: `sudo docker ps`
* To get access and run commands in that Docker container, type the following: `sudo docker exec –it {container-id} /bin/bash`

### Installing Apache Ant

* [Log into the container with SSH](#ssh-into-a-docker-container)
* To install ant, run:
    * `mkdir -p /usr/share/man/man1`
    * `apt-get install -y openjdk-11-jdk`
    * `apt-get install ant -y`

## Vagrant

## Requirements

* [Vagrant](https://www.vagrantup.com/downloads) (latest version) 
* [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

**Additional requirements for Windows**

* Admin rights
* The latest **PowerShell** version (minimum v3). Update in admin mode: `choco upgrade powershell`
* **Hyper-V cmdlets for PowerShell** to control Hyper-V. Please enable them in the
  "Windows Features" control panel.
* Optional: [Chocolatey](https://chocolatey.org/)

## Vagrant Box Setup

Create a file `Vagrantfile` and copy/paste this content:

{% raw %}
```
# -*- mode: ruby -*-
# vi: set ft=ruby :
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/focal64"
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.network "forwarded_port", guest: 80, host: 8765
  #config.vm.network "forwarded_port", guest: 9000, host: 9001
  #config.vm.network "private_network", ip: "192.168.56.99"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
    vb.customize ['modifyvm', :id, '--cableconnected1', 'on']
  end  
end
```
{% endraw %}

Create a file: `bootstrap.sh` and copy/paste this content:

{% raw %}
```sh
#!/usr/bin/env bash

apt-get update
apt-get install vim -y

# unzip is for composer
apt-get install unzip -y

# apache ant (optional)
#apt-get install ant -y

apt-get install apache2 -y

if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www
fi

apt-get install mysql-server mysql-client libmysqlclient-dev -y
apt-get install libapache2-mod-php7.4 php7.4 php7.4-mysql php7.4-sqlite -y
apt-get install php7.4-mbstring php7.4-curl php7.4-intl php7.4-gd php7.4-zip php7.4-bz2 -y
apt-get install php7.4-dom php7.4-xml php7.4-soap -y
apt-get install --reinstall ca-certificates -y

# Enable apache mod_rewrite
a2enmod rewrite
a2enmod actions

# Change AllowOverride from None to All (between line 170 and 174)
sed -i '170,174 s/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Start the webserver
service apache2 restart

# Start the database server
service mysql start

# Change root user to native password authentication
mysql -u root --password="" -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';"
mysql -u root --password="" -e "flush privileges;"

# Install composer
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
composer self-update

# Create a new project:
mkdir /var/www/html
cd /var/www/html
composer create-project --prefer-dist --no-interaction --no-progress odan/slim4-skeleton .

# Set permissions
chown -R www-data tmp/
chown -R www-data logs/

chmod -R 760 tmp/
chmod -R 760 logs/

cp config/env.example.php config/env.php
vendor/bin/phoenix migrate

# Run tests
vendor/bin/phpunit
```
{% endraw %}

* For the first time, start the guest machine with: `vagrant up --provider virtualbox`
* Later, start the guest machine with:  `vagrant up` and `vagrant ssh`
* Open in your browser: <http://localhost:8765>
