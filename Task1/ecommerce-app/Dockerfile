# ===============================
# Stage 1 - Build Frontend (Vite)
# ===============================
FROM node:18 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ===============================
# Stage 2 - Backend (Laravel)
# ===============================
FROM php:8.2-cli

# Install system dependencies + PostgreSQL driver
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

# Start Laravel properly
CMD sh -c "\
php artisan key:generate && \
php artisan migrate --force && \
php artisan serve --host=0.0.0.0 --port=10000"