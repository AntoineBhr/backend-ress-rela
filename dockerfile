FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application source
COPY . .

# Install application dependencies
RUN composer install --prefer-dist --no-progress

# Expose port
EXPOSE 9000

CMD ["php-fpm"]