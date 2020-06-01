#
# Use this dockerfile to run the application.
#
# Start the server using docker-compose:
#
#   docker-compose build
#   docker-compose up
#
# NOTE: In future examples replace {{volume_name}} with your projects desired volume name
#
# You can install dependencies via the container:
#
#   docker-compose run {{volume_name}} composer install
#
# You can manipulate dev mode from the container:
#
#   docker-compose run {{volume_name}} composer development-enable
#   docker-compose run {{volume_name}} composer development-disable
#   docker-compose run {{volume_name}} composer development-status
#
# OR use plain old docker
#
#   docker build -f Dockerfile-dev -t {{volume_name}} .
#   docker run -it -p "8080:80" -v $PWD:/var/www {{volume_name}}
#
FROM php:7.4-apache

RUN apt-get update \
 && apt-get install -y vim git libssl-dev default-mysql-client libmcrypt-dev \
    libjpeg62-turbo-dev libjpeg-dev libpng-dev zlib1g-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install gd mbstring pdo pdo_mysql mysqli zip \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && echo 'xdebug.remote_autostart=0' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.remote_host=host.docker.internal' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.remote_port=9000' >>  /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.remote_cookie_expire_time=36000' >>  /usr/local/etc/php/conf.d/xdebug.ini \
 && a2enmod rewrite \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer \
 && echo "ServerName docker" >> /etc/apache2/apache2.conf

WORKDIR /var/www
