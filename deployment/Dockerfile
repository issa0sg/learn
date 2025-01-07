FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/download/latest-stable/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

RUN groupadd --gid $GID appgroup \ 
    && useradd --uid $UID --gid appgroup --shell /bin/bash --create-home appuser

COPY deployment/nginx/nginx.conf        /etc/nginx/nginx.conf
COPY deployment/nginx/default.conf      /etc/nginx/conf.d/default.conf
COPY deployment/php/php.ini             /usr/local/etc/php/php.ini
COPY deployment/supervisord.conf        /etc/supervisor/supervisord.conf

RUN usermod -aG www-data appuser

RUN chown -R appuser:www-data /var/www && chmod -R g+w /var/www

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]