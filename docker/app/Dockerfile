FROM kimiriecs/php:8.2-fpm as php

ARG PUID=1000
ARG PGID=1000

RUN apk add --no-cache nodejs npm

RUN apk add --no-cache shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html/  \
    && chmod -R 755 /var/www/html/

EXPOSE 9000
ENTRYPOINT ["php-fpm"]