FROM php:8.0-fpm-alpine

RUN apk update
RUN apk add g++ icu-dev zip libzip-dev zip make bash postgresql-dev rabbitmq-c-dev
RUN apk add --no-cache --update --virtual buildDeps autoconf
RUN docker-php-ext-install zip intl opcache pdo_pgsql
RUN pecl install xdebug apcu
RUN docker-php-ext-enable apcu xdebug
RUN apk del make buildDeps autoconf
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/docker-php-ext-amqp.ini /usr/local/etc/php/conf.d/docker-php-ext-amqp.ini
COPY docker/amqp.so /usr/local/lib/php/extensions/no-debug-non-zts-20200930/amqp.so

WORKDIR /app

RUN curl --silent --show-error https://getcomposer.org/installer | php
