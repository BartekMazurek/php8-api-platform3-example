FROM php:8.2-fpm

RUN apt-get update -y && apt-get upgrade -y

# INSTALL REQUIRED PACKAGES
RUN apt-get install libzip-dev unzip -y
RUN docker-php-ext-configure zip && docker-php-ext-install zip
RUN apt-get install -y libpq-dev && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo pdo_pgsql pgsql;
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# INSTALL PACKAGES FOR POSTMAN TESTS
RUN apt install nodejs -y
RUN apt install npm -y
RUN npm install -g newman -y

WORKDIR /var/www/app

COPY ./docker/php/php.ini $PHP_INI_DIR/
