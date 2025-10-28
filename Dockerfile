# Etapa 1: dependencias PHP (Composer)
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction

# Etapa 2: build de assets (Node)
FROM node:18 AS build
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
# Copiamos vendor para que Tailwind/WireUI exista durante el build
COPY --from=vendor /app/vendor /app/vendor
RUN npm run build

# Etapa 3: runtime PHP + Apache
FROM php:8.2-apache
WORKDIR /var/www/html
RUN docker-php-ext-install pdo pdo_mysql

# Copiamos app + vendor + assets ya compilados
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=build /app /var/www/html

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80