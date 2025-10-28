# ===== Etapa 1: Composer =====
FROM php:8.2-cli AS vendor
ENV COMPOSER_ALLOW_SUPERUSER=1 DEBIAN_FRONTEND=noninteractive
WORKDIR /app
RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --no-scripts

# ===== Etapa 2: Build de assets =====
FROM node:18 AS build
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
COPY --from=vendor /app/vendor /app/vendor
RUN npm run build

# ===== Etapa 3: Runtime PHP + Apache =====
FROM php:8.2-apache
ENV DEBIAN_FRONTEND=noninteractive
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
WORKDIR /var/www/html

RUN set -eux; \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/000-default.conf \
        /etc/apache2/sites-available/default-ssl.conf \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf || true; \
    apt-get update; \
    apt-get install -y --no-install-recommends libzip-dev unzip git; \
    docker-php-ext-install pdo pdo_mysql zip bcmath; \
    a2enmod rewrite; \
    rm -rf /var/lib/apt/lists/*

# Copiar código, vendor y build
COPY . .
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=build /app/public/build /var/www/html/public/build

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80