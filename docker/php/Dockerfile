FROM php:8.3-fpm-alpine

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]