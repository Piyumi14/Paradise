#!/bin/sh

# Exit on error
set -e

# Run migrations with --force (to avoid issues with production environment)
echo "Checking if migrations need to be run..."
if ! php artisan migrate --pretend | grep -q "Nothing to migrate"; then
    echo "Running migrations..."
    php artisan migrate --force
else
    echo "Migrations already applied, skipping..."
fi

# Generate Passport keys if they don't exist
if [ ! -f storage/oauth-private.key ] || [ ! -f storage/oauth-public.key ]; then
    echo "Generating Laravel Passport keys..."
    php artisan passport:keys
    chmod -R 755 storage/oauth
    chown -R www-data:www-data storage/oauth
else
    echo "Passport keys already exist, skipping key generation..."
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
if [ ! -L public/storage ] && [ -d storage/app/public ]; then
    echo "Creating storage symbolic link..."
    php artisan storage:link
else
    echo "Storage symbolic link already exists, skipping..."
fi

# Generate application key if .env does not exist
if [ ! -f .env ]; then
    echo "Generating application key..."
    php artisan key:generate
fi

exec "$@"
