FROM schedulia/php-nginx:0.0.3

COPY .deploy/shared/nginx-site.conf /etc/nginx/sites-enabled/default
COPY ./ /app
RUN rm -rf .deploy && \
	chown -R $USERNAME:$USERNAME /app && \
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
	php artisan migrate && \
	php artisan config:clear
