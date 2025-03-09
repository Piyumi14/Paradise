#!/bin/sh

# Exit on error
set -e

# Run migrations with --force (to avoid issues with production environment)
echo "Running migrations..."
php artisan migrate --force

# passport:install will create the encryption keys needed to generate secure access tokens
echo "Installing Laravel Passport..."
php artisan key:generate
php artisan passport:install --force --no-interaction

# Generate Passport keys if they don't exist
if [ ! -f storage/oauth-private.key ] || [ ! -f storage/oauth-public.key ]; then
    echo "Generating Laravel Passport keys..."
    php artisan passport:keys
    chmod -R 755 storage/oauth
    chown -R www-data:www-data storage/oauth
fi

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear and cache configurations
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create symbolic storage link (if not already created)
echo "Creating storage symbolic link..."
php artisan storage:link || true

# Generate application key if it's not set
if [ ! -f .env ]; then
    echo "Generating application key..."
    php artisan key:generate
fi


exec "$@"
