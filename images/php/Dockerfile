FROM php:8.0-cli

RUN apt-get update && apt-get install -y libxml2-dev
RUN pecl install pcov && docker-php-ext-enable pcov
RUN docker-php-ext-install -j$(nproc) soap
RUN docker-php-ext-enable soap

WORKDIR /var/www
