FROM php:8.3-fpm-alpine

# ติดตั้ง dependencies
RUN apk add --no-cache \
    bash git unzip icu-dev libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev \
    libxml2-dev libzip-dev curl-dev

# PHP extensions ที่พบบ่อย
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) pdo pdo_mysql gd intl mbstring opcache xml zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# php.ini
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/html

# เพิ่ม user กลุ่ม www-data ให้สิทธิ์กับ storage/bootstrap
RUN addgroup -g 1000 www && adduser -G www -g www -s /bin/sh -D www \
 && chown -R www:www /var/www/html
USER www

CMD ["php-fpm","-F"]
