FROM schedulia/php-nginx:0.0.2

COPY .deploy/shared/nginx-site.conf /etc/nginx/sites-enabled/default
COPY --chown=$USERNAME:$USERNAME ./ /app
RUN rm -rf .deploy && \
	php artisan migrate --force && \
	php artisan config:clear && \
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

ENTRYPOINT ["/etc/entrypoint.sh"]
