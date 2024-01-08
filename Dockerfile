FROM php:8.1-cli AS builder
LABEL maintainer="Ernesto Suárez Ramírez <ernestosu16@gmail.com>"

RUN apt-get update && apt-get install -y git unzip zip git make curl wget mc

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Instalando extenciones de PHP
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

WORKDIR /app

FROM builder AS developer

RUN install-php-extensions xdebug-^3.2 && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini

ARG DEVELOPER_USER
RUN useradd -ms /bin/bash ${DEVELOPER_USER}
USER ${DEVELOPER_USER}
