FROM php:7.4-fpm-alpine

WORKDIR /app

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x /usr/local/bin/composer \
    && apk --no-cache add bash git libzip libzip-dev unzip autoconf \
    && docker-php-ext-install pdo_mysql bcmath zip

COPY ./configs/php-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/php-entrypoint.sh

ENTRYPOINT ["php-entrypoint.sh"]
