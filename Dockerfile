# Etapa 1: Composer + PHP (con bcmath)
FROM php:8.2-cli AS vendor
WORKDIR /app

# Instalar extensiones necesarias para resolver dependencias
RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install bcmath

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos de Composer e instalar dependencias (sin dev)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction

# Etapa 2: Build de assets (Node)
FROM node:18 AS build
WORKDIR /app
COPY package*.json ./
RUN npm ci

# Copiar todo el código + vendor para que Tailwind/WireUI exista en el build
COPY . .
COPY --from=vendor /app/vendor /app/vendor

# Compilar assets
RUN npm run build

# Etapa 3: Runtime PHP + Apache
FROM php:8.2-apache
WORKDIR /var/www/html

# Extensiones necesarias en producción
RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip bcmath \
    && a2enmod rewrite

# Copiar app, vendor y assets compilados
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=build /app /var/www/html

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80