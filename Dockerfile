# Etapa 1: Construcción de assets
FROM node:18 AS build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Etapa 2: Servidor PHP
FROM php:8.2-apache
WORKDIR /var/www/html

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos de Laravel
COPY --from=build /app /var/www/html

# Dar permisos a Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80