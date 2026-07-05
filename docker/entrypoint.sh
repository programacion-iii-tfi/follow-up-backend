#!/bin/sh
set -e

sed -i "s/listen 8080/listen ${PORT:-8080}/" /etc/nginx/http.d/default.conf

php artisan config:cache
php artisan route:cache

exec supervisord -c /etc/supervisord.conf