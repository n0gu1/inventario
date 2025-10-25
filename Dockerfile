# Etapa 1: Construcción
FROM composer:2 AS build

WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:clear && \
    php artisan route:clear

# Etapa 2: Producción con servidor PHP
FROM php:8.2-cli

WORKDIR /app

# Instala dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip curl git && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl

COPY --from=build /app /app

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
