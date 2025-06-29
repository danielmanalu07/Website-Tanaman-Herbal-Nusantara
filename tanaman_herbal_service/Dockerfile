# ────────────────────────────────
# PHP 8.2 + Apache sebagai dasar
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
    # GD – aktifkan dukungan JPEG+FreeType
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip mbstring && \
    # PECL Imagick
    pecl install imagick && \
    docker-php-ext-enable imagick && \
    # bersih‑bersih
    apt-get clean && rm -rf /var/lib/apt/lists/*

# ────────────────────────────────
# Apache document root → /public
# ────────────────────────────────
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf && \
    a2enmod rewrite headers

# ────────────────────────────────
# Tambah Composer
# ────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1 COMPOSER_NO_INTERACTION=1

# ────────────────────────────────
WORKDIR /var/www/html

# Salin & install dependensi prod
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts \
    --optimize-autoloader --prefer-dist --no-progress

# Salin source lainnya
COPY . .

RUN composer dump-autoload --no-dev --optimize

# Laravel bootstrap
RUN php artisan key:generate --force --no-interaction && \
    php artisan storage:link || true && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force --no-interaction && \
    php artisan db:seed --class=RolePermissionSeeder   --force --no-interaction && \
    php artisan db:seed --class=AdminSeeder            --force --no-interaction

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache

# Railway akan meng‑inject $PORT
EXPOSE 8002
CMD ["apache2-foreground"]
