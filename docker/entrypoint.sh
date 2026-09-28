#!/bin/sh
set -e

# Set directory permissions for Laravel storage and cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage link if not exists
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link || true
fi

# Execute main command (defaults to supervisord)
exec "$@"
