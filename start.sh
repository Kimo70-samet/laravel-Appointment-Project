#!/bin/bash

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