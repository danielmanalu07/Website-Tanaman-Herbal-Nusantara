FROM php:8.2-fpm

# Install dependencies
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

# Set permissions for Laravel
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy .env (fallback only, Railway akan override di deploy)
RUN cp .env.example .env 2>/dev/null || true

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts \
    && npm ci

# Expose port (optional for Railway)
EXPOSE 8000

# ✅ Jalankan Laravel Artisan hanya saat container dijalankan
CMD sh -c "\
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan key:generate --force --no-interaction && \
    chmod -R 775 storage bootstrap/cache && \
    php-fpm"
