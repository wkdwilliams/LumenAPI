FROM php:7.4-apache
 
# Set working directory
WORKDIR /var/www/html
 
# Install dependencies for the operating system software
RUN apt-get update
# RUN apt-get install -y libpng-dev libjpeg-dev libjpeg62-turbo-dev libfreetype6-dev libmemcached-dev wget
RUN docker-php-ext-install mysqli pdo pdo_mysql gd
RUN apt-get install -y htop iputils-ping
# RUN apt-get install nano

# Install composer
# RUN wget https://getcomposer.org/installer -O /tmp/composer-setup.php
# RUN php /tmp/composer-setup.php
# RUN rm /tmp/composer-setup.php
# RUN mv composer.phar /usr/local/bin/composer

# RUN set -ex \
#     && DEBIAN_FRONTEND=noninteractive apt-get install -y libmemcached-dev \
#     && rm -rf /var/lib/apt/lists/* \
#     && MEMCACHED="`mktemp -d`" \
#     && curl -skL https://github.com/php-memcached-dev/php-memcached/archive/master.tar.gz | tar zxf - --strip-components 1 -C $MEMCACHED \
#     && docker-php-ext-configure $MEMCACHED \
#     && docker-php-ext-install $MEMCACHED \
#     && rm -rf $MEMCACHED
	
RUN a2enmod rewrite
 
# Copy .env dev to .env
# RUN cp .env.development .env