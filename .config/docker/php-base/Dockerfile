FROM php:7.4.7-fpm

WORKDIR /app

ARG UID=1000
ARG GID=1000
ENV USERNAME=www-data
# PHP_CPPFLAGS are used by the docker-php-ext-* scripts
ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"

# Fix permissions
RUN usermod -u $UID $USERNAME \
    && groupmod -g $GID $USERNAME \
    && mkdir -p /home/$USERNAME \
    && chown -R $USERNAME:$USERNAME /home/$USERNAME \
    && mkdir -p /app \
    && chown $USERNAME:$USERNAME /app \
    && chown -R $USERNAME:$USERNAME /var/www


RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/php-opocache-cfg.ini

RUN pecl channel-update pecl.php.net \
    && pecl install redis-4.3.0

# Install selected extensions and other stuff
RUN apt-get update && apt-get -y --no-install-recommends install \
    libpq-dev \
	libpng-dev \
	libwebp-dev \
	libjpeg62-turbo-dev \
	libmcrypt-dev \
	libzip-dev \
	zip \
	unzip \
    && docker-php-ext-install pdo_pgsql bcmath sockets gd zip opcache \
    && docker-php-ext-enable redis \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN mkdir -p public/storage \
    && ln -s /app/storage/app/public /app/public/storage/files

USER $USERNAME
