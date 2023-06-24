# Use an official PHP runtime as a parent image
FROM php:7.4-fpm

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the composer.json and composer.lock files to the working directory
COPY composer.json composer.lock ./

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install --no-interaction --optimize-autoloader --no-suggest

# Copy the rest of the application code to the working directory
COPY . .

# Set the permissions for the storage and bootstrap/cache directories
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Install MySQL server
RUN apt-get update && apt-get install -y \
    mysql-server \
    && rm -rf /var/lib/apt/lists/*

# Copy the MySQL configuration file to the container
COPY my.cnf /etc/mysql/conf.d/

# Set the MySQL root password
ENV MYSQL_ROOT_PASSWORD=my-secret-pw

# Expose ports for PHP-FPM and MySQL
EXPOSE 9000 3306

# Start the PHP-FPM and MySQL servers
CMD ["bash", "-c", "service mysql start && php-fpm"]
