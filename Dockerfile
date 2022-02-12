FROM php:7.4-apache
 
# Set working directory
WORKDIR /var/www/html
 
# Install dependencies for the operating system software
RUN apt-get update
RUN docker-php-ext-install mysqli pdo pdo_mysql gd
RUN apt-get install -y htop iputils-ping

RUN a2enmod rewrite
