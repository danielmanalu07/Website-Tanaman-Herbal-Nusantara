#!/bin/bash

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set port dari environment variable atau default 8080
PORT=${PORT:-8080}

# Start server
php artisan serve --host=0.0.0.0 --port=$PORT
