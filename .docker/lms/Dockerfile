FROM php:8.1-fpm-alpine

RUN apk add --no-cache nodejs npm libzip-dev zip freetype freetype-dev libpng libpng-dev libjpeg-turbo libjpeg-turbo-dev

RUN docker-php-ext-configure gd

# Install extensions
RUN docker-php-ext-install pdo_mysql bcmath zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Configure PHP
COPY php.ini $PHP_INI_DIR/conf.d/opcache.ini

# Use the default development configuration
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini