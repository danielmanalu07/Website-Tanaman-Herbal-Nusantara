# Gunakan image PHP CLI yang sesuai
FROM php:8.2-cli

# Install sistem dependency & ekstensi PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set direktori kerja aplikasi
WORKDIR /var/www

# Salin semua source code
COPY . .

# Set permission folder Laravel
RUN chmod -R 775 storage bootstrap/cache

# Set env build-time (safe untuk Railway)
ENV CACHE_DRIVER=file
ENV SESSION_DRIVER=file
ENV QUEUE_CONNECTION=sync

# Install dependencies dan jalankan migration
RUN composer install --no-dev --prefer-dist --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && composer dump-autoload \
    && php artisan migrate --force

# Expose port Laravel serve
EXPOSE 8000

# Jalankan Laravel secara built-in dengan PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
