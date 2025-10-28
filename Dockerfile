FROM webdevops/php-nginx:8.2-alpine

WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

EXPOSE 8080

CMD ["supervisord"]