---
layout: default
title: Vagrant
parent: Installation
nav_order: 3
---

# Vagrant Development Environment 

## Requirements

* The latest version of Vagrant
* [VirtualBox](https://www.virtualbox.org/wiki/Download_Old_Builds_6_0). Install only one of the supported versions: 4.0, 4.1, 4.2, 4.3, 5.0, 5.1, 5.2, 6.0

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
  config.vm.box = "ubuntu/bionic64"
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.network "forwarded_port", guest: 80, host: 8765
  #config.vm.network "forwarded_port", guest: 9000, host: 9001
  #config.vm.network "private_network", ip: "192.168.56.99"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
    vb.customize ['modifyvm', :id, '--uartmode1', 'disconnected']
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
apt-get install libapache2-mod-php7.2 php7.2 php7.2-mysql php7.2-sqlite -y
apt-get install php7.2-mbstring php7.2-curl php7.2-intl php7.2-gd php7.2-zip php7.2-bz2 -y
apt-get install php7.2-dom php7.2-xml php7.2-soap -y
apt-get install --reinstall ca-certificates -y

# Enable apache mod_rewrite
a2enmod rewrite
a2enmod actions

# Change AllowOverride from None to All (between line 170 and 174)
sed -i '170,174 s/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Start the webserver
service apache2 restart

# Change mysql root password
service mysql start
mysql -u root --password="" -e "update mysql.user set authentication_string=password(''), plugin='mysql_native_password' where user='root';"
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
composer migration:migrate

# Run tests
vendor/bin/phpunit
```
{% endraw %}

* For the first time, start the guest machine with: `vagrant up --provider virtualbox` 
* Later, start the guest machine with:  `vagrant up` and `vagrant ssh`
* Open in your browser: <http://localhost:8765>

