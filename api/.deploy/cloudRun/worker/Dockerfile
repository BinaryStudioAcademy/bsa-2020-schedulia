FROM schedulia/php-nginx:0.0.3

COPY --chown=$USERNAME:$USERNAME ./ /app
COPY .deploy/cloudRun/worker/entrypoint.sh /etc/entrypoint.sh
RUN rm -rf .deploy && \
	mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
	chmod +x /etc/entrypoint.sh
