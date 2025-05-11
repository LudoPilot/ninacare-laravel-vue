# Stage 1 : Install Composer dependencies
FROM php:8.2-cli AS php-builder

ENV TZ=Europe/Paris

RUN apt-get update \
	&& apt-get install -y git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
	&& docker-php-ext-install pdo_mysql zip gd mbstring xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader \
	&& php artisan config:cache \
	&& php artisan route:cache \
	&& php artisan view:cache

# Stage 2 : Build frontend assets
FROM node:20-alpine AS node-builder

WORKDIR /app
COPY --from=php-builder /app /app
RUN npm ci && npm run build

# Stage 3 : Final image with PHP + built assets
FROM php:8.2-fpm-alpine

# ➕ Ajout pour Alpine : installation de pdo_mysql
RUN apk add --no-cache libzip-dev libpng-dev libxml2-dev oniguruma-dev \
	&& docker-php-ext-install pdo_mysql zip gd mbstring xml

WORKDIR /var/www
COPY --from=node-builder /app /var/www

RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www \
	&& chown -R www:www /var/www

#EXPOSE 9000
EXPOSE 9000
CMD ["php-fpm", "-F"]
