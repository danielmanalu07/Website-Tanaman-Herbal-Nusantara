# ───────────────────────────
# 1. Base image PHP 8.2 CLI
# ───────────────────────────
FROM php:8.2-cli

# 2. Ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y --no-install-recommends \
    libmagickwand-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev unzip git ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip mbstring \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Tambah Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# 4. Workspace
WORKDIR /app

# 5. Install vendor (tanpa script)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist

# 6. Copy source
COPY . .

RUN composer dump-autoload --no-dev --optimize
RUN php artisan key:generate --force --no-interaction

# 7. Beri writable storage
RUN chown -R www-data:www-data storage bootstrap/cache


# 9. Start Laravel dev server + migrate + seeder
CMD bash -c "\
    php artisan migrate --force --no-interaction && \
    php artisan db:seed --class=RolePermissionSeeder --force --no-interaction && \
    php artisan db:seed --class=AdminSeeder          --force --no-interaction && \
    php artisan storage:link --force || true && \
    php artisan serve --host=0.0.0.0 --port=8002"
