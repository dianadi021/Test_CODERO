# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip bcmath sockets \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer (Versi terbaru)
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copy application code (dengan pengecualian file yang tidak perlu)
COPY . /var/www/html

# Set permissions for Laravel (lebih rapi dan efisien)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 777 public

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
