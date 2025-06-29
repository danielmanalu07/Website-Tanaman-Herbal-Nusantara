FROM php:8.2-cli

# 1) Install paket sistem & PHP extension dasar
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev unzip git ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2) Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# 3) Direktori kerja
WORKDIR /var/www/html

# 4) Salin file composer & install dependensi
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist

# 5) Salin semua source code Laravel
COPY . .

# 6) Autoload & folder Laravel
RUN composer dump-autoload --no-dev --optimize \
    && mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 7) Jalankan Laravel built-in server (blade only)
CMD bash -c '\
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force || true && \
    php artisan storage:link --force || true && \
    php artisan config:cache && \
    php artisan route:cache && \
    echo "✅ Laravel is ready." && \
    echo "📄 Showing last 20 lines from laravel.log (if any):" && \
    tail -n 20 storage/logs/laravel.log || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}'

# Railway akan gunakan ENV PORT (default: 8080)
EXPOSE 8080
