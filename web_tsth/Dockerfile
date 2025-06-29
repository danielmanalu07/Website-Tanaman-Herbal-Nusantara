FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    nano \
    libcurl4-openssl-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Create necessary Laravel directories
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Generate .env if not exists
RUN cp .env.example .env 2>/dev/null || echo "APP_NAME=Laravel\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=true\nAPP_URL=http://localhost\nCACHE_DRIVER=file\nSESSION_DRIVER=file\nQUEUE_CONNECTION=sync\nLOG_CHANNEL=single" > .env

# Install PHP and JS dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts \
    && php artisan key:generate --force --no-interaction \
    && npm ci

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port (Railway will map this)
EXPOSE 8080

# Start PHP-FPM
CMD ["php-fpm"]
