FROM php:7.4.33-apache
# SETTING WORKING DIRECTORY
WORKDIR /var/www/html
# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql
# COPYING LOCAL DIRECTORY
COPY . . 
# EXPOSING PORT 80 TO THE WORLD
EXPOSE 80