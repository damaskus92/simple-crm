FROM php:8.3-fpm

# Install dependencies and update packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    zip \
    unzip \
    git \
    bash \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libwebp-dev \
    libzip-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql gd mbstring zip exif pcntl bcmath opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.7.9 --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# Prepare a working directory
WORKDIR /var/www/html

# Copy the project files
COPY . .

# Set ownership and permissions for a directory
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Change current user
USER www-data

# Expose port PHP-FPM and start PHP-FPM server
EXPOSE 9000

# Healthcheck for PHP-FPM server
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 CMD curl -f http://localhost:9000 || exit 1

# Run PHP-FPM
CMD ["php-fpm"]
