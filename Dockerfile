# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copy project files into container
COPY . /var/www/html

# Install Composer inside container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies (composer)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Fix folder permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (Apache)
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
