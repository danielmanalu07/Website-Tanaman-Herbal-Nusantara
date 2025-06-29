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

# 3) Set direktori kerja aplikasi
WORKDIR /app

# 4) Salin file composer dan install dependensi
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist

# 5) Salin semua file proyek
COPY . .
RUN composer dump-autoload --no-dev --optimize

# 6) Buat folder Laravel yang dibutuhkan dan set permission
RUN mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 7) Jalankan proses Laravel saat runtimes
CMD bash -c '\
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force || true && \
    php artisan storage:link --force || true && \
    php artisan config:cache && \
    php artisan route:cache && \
    echo "✅ Laravel ready. Showing latest error log if exists..." && \
    tail -n 50 storage/logs/laravel.log || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8001}'


# Railway akan gunakan ENV PORT jadi ini tetap di-expose
EXPOSE 8001
