# Use the official PHP 8.2 image
FROM php:8.2-apache

# Install system packages (git, unzip, libzip-dev) and PHP Extensions
RUN apt-get update && \
    apt-get install -y git unzip libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip mysqli pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Install PDO MySQL Extension
RUN docker-php-ext-install pdo_mysql

# Copy application source
COPY . /var/www/html/

# Install PHP dependencies
RUN composer install

# Set "public" directory as document root
WORKDIR /var/www/html
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

