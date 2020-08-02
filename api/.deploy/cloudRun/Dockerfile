FROM schedulia/php-nginx:0.0.2

COPY .deploy/shared/nginx-site.conf /etc/nginx/sites-enabled/default
COPY --chown=$USERNAME:$USERNAME ./ /app
RUN rm -rf .deploy && \
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

