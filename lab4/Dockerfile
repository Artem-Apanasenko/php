FROM php:8.0-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
WORKDIR /var/www/html/
COPY config.php.docker /var/www/html/config.php