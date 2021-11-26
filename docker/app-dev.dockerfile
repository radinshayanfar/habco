FROM php:8.0.13-fpm-alpine3.14

RUN apk add --no-cache git \
    gcc g++ curl make libc-dev make libcurl curl-dev \
    icu-dev libpng-dev libxml2-dev zip unzip libzip-dev \
    sqlite-dev oniguruma-dev autoconf \
    && docker-php-source extract && \
    docker-php-ext-install bcmath curl gd intl mbstring \
    pdo_sqlite soap xml zip \
    && pecl install redis-5.3.4 \
    && docker-php-ext-enable redis \
    && docker-php-source delete \
    && apk del git gcc g++ libc-dev make


RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 8080

WORKDIR /app
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
