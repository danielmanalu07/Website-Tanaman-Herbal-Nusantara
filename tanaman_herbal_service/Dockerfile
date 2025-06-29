# ────────────────────────────────
# PHP 8.2 + Apache
# ────────────────────────────────
FROM php:8.2-apache

# ────────────────────────────────
# Sistem & ekstensi PHP
# ────────────────────────────────
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    build-essential pkg-config \
    libmagickwand-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev \
    unzip git ca-certificates && \
    # GD – dukungan JPEG + FreeType
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip mbstring && \
    # PECL Imagick
    pecl install imagick && \
    docker-php-ext-enable imagick && \
    # bersih‑bersih
    apt-get clean && rm -rf /var/lib/apt/lists/*

# ────────────────────────────────
# Dokumen root Apache → /public
# ────────────────────────────────
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf && \
    a2enmod rewrite headers && \
    \
    # ▸ Tambah ServerName agar warning AH00558 hilang
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ────────────────────────────────
# Composer
# ────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1 COMPOSER_NO_INTERACTION=1

# ────────────────────────────────
WORKDIR /var/www/html

# Dependensi PHP (tanpa scripts)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts \
    --optimize-autoloader --prefer-dist --no-progress

# Aplikasi
COPY . .
RUN composer dump-autoload --no-dev --optimize

# Laravel bootstrap
RUN php artisan key:generate      --force --no-interaction && \
    php artisan storage:link      || true                     && \
    php artisan config:cache      && \
    php artisan route:cache       && \
    php artisan migrate           --force --no-interaction && \
    php artisan db:seed --class=RolePermissionSeeder --force --no-interaction && \
    php artisan db:seed --class=AdminSeeder          --force --no-interaction

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache

# ────────────────────────────────
# Expose & start
# ────────────────────────────────
EXPOSE 80
CMD ["apache2-foreground"]
