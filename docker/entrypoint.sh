#!/bin/sh
set -e

# Cache configuration, routes, and views if in production
if [ "$APP_ENV" = "production" ] || [ "$APP_ENV" = "prod" ] || [ "$APP_ENV" = "staging" ] || [ "$APP_ENV" = "uat" ]; then
    echo "Running optimization caches..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Ensure storage directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

exec "$@"
