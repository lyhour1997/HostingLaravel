FROM php:8.2

# Install extensions
RUN apt-get update && apt-get install -y \
    libpq-dev unzip curl git zip \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Start Laravel via PHP's built-in web server
CMD php artisan migrate --force && php -S 0.0.0.0:8080 -t public
