
FROM php:8.2-apache

WORKDIR /var/www/html

COPY src/ /var/www/html/

RUN docker-php-ext-install mysqli \
    && a2enmod rewrite \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
