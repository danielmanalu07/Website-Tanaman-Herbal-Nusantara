FROM php:8.2-cli

# ekstensi
RUN apt-get update && apt-get install -y --no-install-recommends \
    libmagickwand-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --prefer-dist
COPY . .

# (Jangan tambahkan CMD di sini, biarkan Start Command di UI men‑override)
EXPOSE 8000
