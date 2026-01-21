FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# gd for image processing
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/assets/img/projects \
    && chown -R www-data:www-data /var/www/html/assets \
    && chmod -R 755 /var/www/html/assets

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_file_uploads = 20" >> /usr/local/etc/php/conf.d/uploads.ini
    
USER www-data