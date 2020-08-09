#!/bin/bash

sed -i "s/80/$PORT/g" /etc/nginx/sites-enabled/default

service nginx start
php artisan queue:work --tries=5
