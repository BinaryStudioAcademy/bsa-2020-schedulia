#!/bin/bash

sed -i "s/80/$PORT/g" /etc/nginx/sites-enabled/default

php artisan queue:work --tries=5
