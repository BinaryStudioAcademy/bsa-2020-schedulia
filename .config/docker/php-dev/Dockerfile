FROM schedulia/php-base:0.0.1

USER root

RUN pecl channel-update pecl.php.net \
    && pecl install xdebug-2.9.6 \
    && docker-php-ext-enable xdebug

# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER $USERNAME
