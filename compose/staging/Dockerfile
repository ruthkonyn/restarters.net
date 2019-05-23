# Dockerfile

FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update -y && apt-get install -y openssl zip unzip git libxml2-dev libzip-dev zlib1g-dev netcat

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer - disabled for now as vendor directory is in the source tree
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install php extensions
RUN docker-php-ext-install pdo pdo_mysql xmlrpc zip

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
RUN chown -Rf www-data.www-data /var/www
