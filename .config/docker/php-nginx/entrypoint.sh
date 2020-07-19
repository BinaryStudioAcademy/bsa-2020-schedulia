#!/usr/bin/env bash

sed -i "s/\$PORT/$PORT/g" /etc/nginx/sites-enabled/default

service nginx start
php-fpm
