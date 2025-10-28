# ===== Etapa 1: Composer (con extensiones requeridas) =====
FROM php:8.2-cli AS vendor
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app

# Extensiones necesarias
RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependencias SIN scripts (para que no intente ejecutar "artisan")
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --no-scripts

# ===== Etapa 2: Build de assets (Node) =====
FROM node:18 AS build
WORKDIR /app

COPY package*.json ./
RUN npm ci

# Copiamos TODO el proyecto + vendor (para WireUI/tailwind preset)
COPY . .
COPY --from=vendor /app/vendor /app/vendor

# Compilación para producción (no usar "npm run dev" en CI)
RUN npm run build

# ===== Etapa 3: Runtime PHP + Apache =====
FROM php:8.2-apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
WORKDIR /var/www/html

# Ajusta DocumentRoot a /public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/.conf \
 && apt-get update && apt-get install -y libzip-dev unzip \
 && docker-php-ext-install pdo pdo_mysql zip bcmath \
 && a2enmod rewrite

# Copiamos código, vendor y assets ya compilados
COPY . .
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=build /app/public/build /var/www/html/public/build

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
# Apache queda como CMD por defecto (apache2-foreground)
# Apache queda como CMD por defecto (apache2-foreground)