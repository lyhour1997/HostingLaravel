FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip sqlite3 libsqlite3-dev \
    libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache
RUN php artisan storage:link || true

CMD php artisan serve --host=0.0.0.0 --port=8080
