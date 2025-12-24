#!/bin/bash

# Create storage directories and set permissions
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p database
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create SQLite database if it doesn't exist
touch database/database.sqlite

# Run migrations
php artisan migrate --force

# Run seeders to create admin user
php artisan db:seed --class=AdminUserSeeder --force

# Cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the server
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}