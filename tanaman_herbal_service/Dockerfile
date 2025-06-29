FROM php:8.2-cli

# 1) Paket sistem + ekstensi PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libmagickwand-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev unzip git ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip mbstring \
    && pecl install imagick && docker-php-ext-enable imagick \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# 3) Workspace
WORKDIR /app

# 4) Install dependency aplikasi
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist

# 5) Salin source code & autoload dump
COPY . .
RUN composer dump-autoload --no-dev --optimize

# 6) Pastikan folder storage & cache ADA + permission
RUN mkdir -p \
    storage/app \
    storage/logs \
    storage/framework/{cache/data,sessions,views} \
    && chown -R www-data:www-data storage bootstrap/cache

# 7) Runtime commands
CMD bash -c '\
    # pastikan direktori runtime ada
    mkdir -p storage/framework/{cache/data,sessions,views} storage/logs; \
    # kosongkan cache konfigurasi lawas
    php artisan config:clear; \
    php artisan view:clear; \
    \
    php artisan migrate --force; \
    php artisan db:seed --class=RolePermissionSeeder --force; \
    php artisan db:seed --class=AdminSeeder       --force; \
    php artisan storage:link --force || true; \
    \
    # (opsional) re‑cache config & route setelah path valid
    php artisan config:cache; \
    php artisan route:cache;  \
    \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000} \
    '

EXPOSE 8000
