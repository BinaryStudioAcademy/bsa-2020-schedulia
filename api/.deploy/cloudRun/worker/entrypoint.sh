#!/bin/bash

sed -i "s/\$PORT/$PORT/g" /etc/nginx/sites-enabled/default

service nginx start
php-fpm -D
echo "[info] start queue worker"
php artisan queue:work --tries=5
