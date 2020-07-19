FROM schedulia/php-nginx:0.0.1

COPY .deploy/heroku/nginx-site.conf /etc/nginx/sites-enabled/default
COPY --chown=$USERNAME:$USERNAME ./ /app
RUN rm -rf .deploy && \
	php artisan migrate && \
	php artisan config:clear
