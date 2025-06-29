#!/bin/bash

echo "=== Starting Laravel Application ==="

# Clear all caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Check Laravel version
echo "Laravel version:"
php artisan --version

# Check if routes file exists
if [ -f "routes/web.php" ]; then
    echo "Routes file exists"
else
    echo "WARNING: routes/web.php not found"
fi

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache

# Check .env file
if [ -f ".env" ]; then
    echo ".env file exists"
    echo "APP_KEY status:"
    grep "APP_KEY=" .env
else
    echo "ERROR: .env file not found"
fi

# Set port dari environment variable atau default 8080
PORT=${PORT:-8080}

echo "Starting server on port $PORT..."
echo "=== Server Starting ==="

# Start server dengan verbose output
php artisan serve --host=0.0.0.0 --port=$PORT --verbose
