FROM php:7.4.33-apache
WORKDIR /var/www/httpanalyzer
COPY . . 
EXPOSE 80