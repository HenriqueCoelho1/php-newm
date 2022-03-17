FROM php:8.0.2-apache

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y mariadb-client libxml2-dev
RUN apt-get autoremove -y && apt-get autoclean
RUN docker-php-ext-install mysqli pdo pdo_mysql xml
COPY --from=composer /usr/bin/composer /usr/bin/composer