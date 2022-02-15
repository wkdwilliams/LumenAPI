FROM php:8.0-apache
 
# Set working directory
WORKDIR /var/www/html
 
# Install dependencies for the operating system software
RUN apt-get update
RUN apt-get -y install zlib1g-dev iputils-ping wget unzip
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install composer
RUN wget https://getcomposer.org/installer -O /tmp/composer-setup.php
RUN php /tmp/composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

RUN a2enmod rewrite
