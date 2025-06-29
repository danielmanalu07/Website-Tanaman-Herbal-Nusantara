FROM php:8.2-cli

# Install dependencies dan extension Laravel
RUN apt-get update && apt-get install -y \
    git unzip curl zip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Set environment (Railway compatible)
ENV CACHE_DRIVER=file
ENV SESSION_DRIVER=file
ENV QUEUE_CONNECTION=sync

# Install dependencies dan optimasi
RUN composer install --no-dev --prefer-dist --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan migrate --force

# Railway uses port 8080 by default
EXPOSE 8080

# Start Laravel using php-cli
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
