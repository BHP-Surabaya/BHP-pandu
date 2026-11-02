#!/bin/sh
set -e

# Configure port (Render, Railway, or local Docker setting $PORT)
PORT="${PORT:-80}"
sed -ri -e "s!Listen [0-9]+!Listen ${PORT}!g" /etc/apache2/ports.conf
sed -ri -e "s!<VirtualHost \*:[0-9]+>!<VirtualHost \*:${PORT}>!g" /etc/apache2/sites-available/000-default.conf

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure .env exists
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        echo "Creating .env from .env.example..."
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Generate APP_KEY if empty in .env and not provided via environment
if [ -z "$APP_KEY" ]; then
    if ! grep -q "^APP_KEY=base64:" /var/www/html/.env 2>/dev/null; then
        echo "Generating application encryption key..."
        php artisan key:generate --force || true
    fi
fi

# Create storage symlink if not present
php artisan storage:link --force || true

# Run migrations if enabled via environment variable
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
fi

# Optimize cache according to environment
if [ "$APP_ENV" = "production" ]; then
    echo "Optimizing application for production..."
    php artisan optimize:clear || true
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
else
    echo "Running in ${APP_ENV:-local} mode, clearing stale cache..."
    php artisan optimize:clear || true
fi

echo "Starting Apache on port ${PORT}..."
exec apache2-foreground
