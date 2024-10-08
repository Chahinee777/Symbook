# Use the official PHP image with Apache and the required PHP version
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    gd \
    intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the Composer binary from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader

# Ensure permissions are set correctly
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
