FROM schedulia/php-nginx:0.0.3

COPY --chown=$USERNAME:$USERNAME ./ /app
COPY .deploy/cloudRun/worker/entrypoint.sh /etc/entrypoint.sh
COPY .deploy/cloudRun/worker/nginx-site.conf /etc/nginx/sites-enabled/default
COPY --chown=$USERNAME:$USERNAME .deploy/cloudRun/worker/scheduler.php /usr/share/nginx/html
RUN rm -rf .deploy && \
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
	chmod +x /etc/entrypoint.sh
