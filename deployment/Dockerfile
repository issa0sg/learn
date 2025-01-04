FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/download/latest-stable/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

COPY deployment/nginx/nginx.conf /etc/nginx/nginx.conf
COPY deployment/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY deployment/php/php.ini /usr/local/etc/php/php.ini
COPY deployment/supervisord.conf /etc/supervisor/supervisord.conf

WORKDIR /var/www

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]