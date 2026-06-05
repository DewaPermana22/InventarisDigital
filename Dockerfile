# Gunakan PHP 8.4 Alpine karena ringan dan memenuhi syarat Symfony 8 / Filament 4
FROM php:8.4-fpm-alpine

# Install system dependencies dan ekstensi PHP yang dibutuhkan Filament & export tools
RUN apk add --no-cache \
    bash \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zlib-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl gd zip pdo_mysql exif

# Ambil Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set folder kerja di dalam container
WORKDIR /app

# Copy seluruh source code aplikasi ke dalam container
COPY . .

# Set permission folder storage dan cache agar Laravel tidak Error 500 (Permission Denied)
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Jalankan instalasi dependensi Laravel secara optimal untuk production
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Optimasi cache konfigurasi dan route bawaan Laravel
# Catatan: Ini membutuhkan APP_KEY sudah terpasang di panel Railway saat deployment berjalan
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Buka port 8080 sesuai standar Railway
EXPOSE 8080

# PERINTAH UTAMA: Otomatis Migrasi, Create Storage Link, dan Jalankan Server
CMD php artisan migrate --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=8080