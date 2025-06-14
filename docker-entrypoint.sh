#!/bin/bash
set -e

# Pastikan permission correct saat container start
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Pastikan storage link ada
if [ ! -L "/var/www/html/public/storage" ]; then
    php artisan storage:link
fi

# Jalankan command yang diberikan
exec "$@"
