# Gunakan official PHP image dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Buat direktori aplikasi
WORKDIR /var/www

# Salin file Laravel ke image
COPY . .

# Set permission untuk storage dan bootstrap
RUN chmod -R 775 storage bootstrap/cache

# Gunakan driver file saat build untuk hindari koneksi ke mysql.railway.internal
ENV CACHE_DRIVER=file
ENV SESSION_DRIVER=file
ENV QUEUE_CONNECTION=sync

# Install dependencies Laravel (tanpa dev)
RUN composer install --no-dev --prefer-dist --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && composer dump-autoload

# Buka port 8000
EXPOSE 8000

# Jalankan Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
