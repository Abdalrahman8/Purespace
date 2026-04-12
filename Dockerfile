# Use the official PHP image with Apache
FROM php:8.2-apache

# Enable required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy project files to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Expose port 80 for the web server
EXPOSE 80