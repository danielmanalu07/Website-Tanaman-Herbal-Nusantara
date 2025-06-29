# ─────────────────────────────────────────────────────────
# ① Base Image : PHP 8.2 (FPM + Apache)
# ─────────────────────────────────────────────────────────
FROM php:8.2-apache

# ─────────────────────────────────────────────────────────
# ② Sistem & ekstensi PHP wajib (GD, Zip, Imagick, dll.)
# ─────────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y --no-install-recommends \
    libmagickwand-dev libpng-dev libjpeg-dev libzip-dev libonig-dev unzip git ca-certificates \
    && docker-php-ext-configure gd --with-jpeg --with-png \
    && docker-php-ext-install gd pdo_mysql zip mbstring \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────────────────────────────────
# ③ Document‑root Apache diarahkan ke /public Laravel
# ─────────────────────────────────────────────────────────
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    && a2enmod rewrite headers

# ─────────────────────────────────────────────────────────
# ④ Tambahkan Composer (dari image resmi) + set env limit
# ─────────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_NO_INTERACTION=1 \
    COMPOSER_DISABLE_XDEBUG_WARN=1

# ─────────────────────────────────────────────────────────
# ⑤ Workspace
# ─────────────────────────────────────────────────────────
WORKDIR /var/www/html

# ─────────────────────────────────────────────────────────
# ⑥ Caching layer vendor – copy composer.* lebih dulu
# ─────────────────────────────────────────────────────────
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-progress

# ─────────────────────────────────────────────────────────
# ⑦ Copy seluruh source & persiapan Laravel
# ─────────────────────────────────────────────────────────
COPY . .

# Generate key & link storage (tidak gagal bila sudah ada)
RUN php -d variables_order=EGP http artisan key:generate --no-interaction --force \
    && php artisan storage:link || true

# ─────────────────────────────────────────────────────────
# ⑧ Cache config/route & migrasi + seeder (opsional)
# ─────────────────────────────────────────────────────────
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan migrate --force --no-interaction \
    && php artisan db:seed --class=RolePermissionSeeder --force --no-interaction \
    && php artisan db:seed --class=AdminSeeder --force --no-interaction

# ─────────────────────────────────────────────────────────
# ⑨ Permission (web user : www-data)
# ─────────────────────────────────────────────────────────
RUN chown -R www-data:www-data storage bootstrap/cache

# ─────────────────────────────────────────────────────────
# ⑩ Railway men‑set env $PORT; Apache akan listen di 0.0.0.0:$PORT
#     kita cukup EXPOSE saja; Runtime env akan di‑inject Railway
# ─────────────────────────────────────────────────────────
EXPOSE 8080

# ─────────────────────────────────────────────────────────
# ⑪ Start Apache
# ─────────────────────────────────────────────────────────
CMD ["apache2-foreground"]
