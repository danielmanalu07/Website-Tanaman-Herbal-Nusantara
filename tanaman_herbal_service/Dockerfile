# ────────────────────────────────
# ① Image dasar : PHP 8.2 + Apache
# ────────────────────────────────
FROM php:8.2-apache

# ② Paket sistem & PHP ext (GD, Zip, Imagick, dll.)
RUN apt-get update && apt-get install -y \
    libmagickwand-dev libpng-dev libjpeg-dev libonig-dev libzip-dev unzip git \
    && docker-php-ext-install pdo_mysql gd zip mbstring \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -rf /var/lib/apt/lists/*

# ③ Set document‑root ke folder Laravel public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/../!g' /etc/apache2/apache2.conf

# ④ Pasang Composer (ambil dari image resmi Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ⑤ Workspace
WORKDIR /var/www/html

# ⑥ Copy composer.* lebih dulu & install dependency prod
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ⑦ Copy source lain & siapkan Laravel
COPY . .

RUN php artisan key:generate --force \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan migrate --force \
    && php artisan db:seed --class=RolePermissionSeeder --force \
    && php artisan db:seed --class=AdminSeeder --force

# ⑧ Permission
RUN chown -R www-data:www-data storage bootstrap/cache

# ⑨ Railway memakai $PORT → ekspose apa saja (80/8080)
EXPOSE 8002

# ⑩ Start Apache
CMD ["apache2-foreground"]
