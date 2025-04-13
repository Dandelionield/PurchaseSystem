FROM php:7.4-fpm

RUN mkdir -p /var/lib/php/sessions && \
    chmod -R 755 /var/lib/php/sessions

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    wget \
    && docker-php-ext-install pdo_mysql zip \
    && wget https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -O /wait-for-it.sh \
    && chmod +x /wait-for-it.sh

RUN echo "date.timezone = America/Bogota" > /usr/local/etc/php/conf.d/timezone.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/PurchaseSystem
COPY . .

RUN composer require php-activerecord/php-activerecord