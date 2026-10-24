# ==========================================
# Stage 1: Build frontend assets (Vite)
# ==========================================
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ==========================================
# Stage 2: Install Composer dependencies
# ==========================================
FROM composer:latest AS vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY . .
RUN composer dump-autoload --optimize

# ==========================================
# Stage 3: Final PHP-FPM image
# ==========================================
FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath gd zip intl

# Set working directory
WORKDIR /var/www/html

# Copy files from stages
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Run as non-root user
USER www-data

# Start PHP-FPM
CMD ["php-fpm"]