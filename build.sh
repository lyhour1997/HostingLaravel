#!/usr/bin/env bash
set -e

# Install PHP dependencies without dev packages
composer install --optimize-autoloader --no-dev

# Cache config, routes, and views to speed up app
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations (apply changes)
php artisan migrate --force

# Create symbolic link for storage (to access uploaded files)
php artisan storage:link
