# Use the official PHP image
FROM php:7.4-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your PHP application files into the container
COPY . /var/www/html

# Install the mysqli extension
RUN docker-php-ext-install mysqli

# Install any additional dependencies your application might need
# For example, if you're using MySQL:
# RUN docker-php-ext-install pdo_mysql
