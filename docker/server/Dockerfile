FROM php:8.1-apache

MAINTAINER Gevorg Melkumyan <gmelkumyan1995@gmail.com>

COPY ./config/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libxml2-dev libpng-dev telnet
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN apt-get update && apt-get install -y libssl-dev zlib1g-dev libpq-dev \
  && docker-php-ext-install pdo pdo_pgsql pcntl gd \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && chown -R www-data:www-data /var/www/html \
  && apt-get update \
  && apt-get install -y vim
RUN a2enmod rewrite \
  && service apache2 restart
RUN cd -- \
  && curl -sS https://getcomposer.org/installer -o composer-setup.php \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && apt-get install -y git

RUN apt-get -y install redis-tools

RUN chown -R www-data:www-data /var/www/html

RUN apt-get update && \
    apt-get install -y supervisor && \
    mkdir -p /var/log/supervisor

COPY ./config/horizon.conf /etc/supervisor/conf.d/horizon.conf
COPY ./mods-available/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
