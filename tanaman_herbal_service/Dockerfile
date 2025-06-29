FROM php:8.2-cli

# 1.  Pasang semua paket sistem + build GD + Imagick LEBIH DULU
RUN apt-get update && apt-get install -y --no-install-recommends \
    libmagickwand-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev unzip git ca-certificates && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip mbstring && \
    pecl install imagick && docker-php-ext-enable imagick && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# 2.  Tambahkan Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# 3.  Workspace
WORKDIR /app

# 4.  COPY composer.* dan install vendor — SELEPAS GD terpasang
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist

# 5.  Copy source & dump autoload
COPY . .
RUN composer dump-autoload --no-dev --optimize

# 6.  Permission storage
RUN chown -R www-data:www-data storage bootstrap/cache

# 7.  CMD hanya untuk runtime (migrate, seed, serve)
CMD bash -c '\
    php artisan migrate --force; \
    php artisan db:seed --class=RolePermissionSeeder --force; \
    php artisan db:seed --class=AdminSeeder --force; \
    php artisan storage:link --force || true; \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000} \
    '

EXPOSE 8000
