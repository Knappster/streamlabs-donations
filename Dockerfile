FROM php:8.2-apache

ARG UID
ARG GID

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN usermod --non-unique --uid ${UID} www-data \
    && groupmod --non-unique --gid ${GID} www-data \
    && chown -R www-data:www-data /var/www