FROM php:8.0.13-fpm-alpine3.14

RUN apk add --no-cache git \
    gcc g++ curl make libc-dev make libcurl curl-dev \
    icu-dev libpng-dev libxml2-dev zip unzip libzip-dev \
    oniguruma-dev autoconf \
    && docker-php-source extract && \
    docker-php-ext-install bcmath curl gd intl mbstring \
    pdo_mysql soap xml zip \
    && pecl install redis-5.3.4 \
    && docker-php-ext-enable redis \
    && docker-php-source delete \
    && apk del git gcc g++ libc-dev make

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
WORKDIR /var/www
COPY composer.json composer.lock .
RUN composer install --no-dev --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump

RUN chown -R www-data:www-data \
        storage \
        bootstrap/cache

EXPOSE 9000
