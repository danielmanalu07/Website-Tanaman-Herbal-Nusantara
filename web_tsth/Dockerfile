FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

# Copy startup script PERTAMA (sebelum copy files lain)
COPY start.sh /app/start.sh
RUN chmod +x /app/start.sh

# Copy composer files
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Copy application files
COPY . .

# Create directories and set permissions
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Setup environment dengan DEBUG=true untuk troubleshooting
RUN cp .env.example .env 2>/dev/null || echo "APP_NAME=Laravel\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=true\nAPP_URL=https://website-tanaman-herbal-nusantara-production.up.railway.app\nCACHE_DRIVER=file\nSESSION_DRIVER=file\nQUEUE_CONNECTION=sync\nLOG_CHANNEL=single" > .env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts
RUN php artisan key:generate --force --no-interaction

RUN npm ci

# Expose port 8080
EXPOSE 8080

# Gunakan script startup
CMD ["/app/start.sh"]
