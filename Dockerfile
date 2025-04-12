FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

RUN echo "date.timezone = America/Bogota" > /usr/local/etc/php/conf.d/timezone.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www  # Directorio de trabajo: raíz del proyecto
COPY . .

RUN composer require php-activerecord/php-activerecord