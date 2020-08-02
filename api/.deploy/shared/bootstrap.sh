#!/bin/bash

php artisan migrate
php artisan config:clear

/etc/entrypoint.sh