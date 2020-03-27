### BASE IMAGE ###
FROM php:7.4-fpm-alpine

### INSTALL EXTS ###
RUN \
  docker-php-ext-install \
    pdo_mysql \
    bcmath

### INSTALL COMPOSER ###
RUN \
  php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
