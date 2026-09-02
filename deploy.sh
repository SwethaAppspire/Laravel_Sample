#!/bin/bash

set -e

echo "Starting deployment..."

echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "Running database migrations..."
php artisan migrate --force

echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Restarting queues..."
php artisan queue:restart

echo "Deployment completed successfully!"