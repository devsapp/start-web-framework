#!/usr/bin/env bash
set +e

mkdir -p /tmp/log/nginx/
mkdir -p /tmp/var/nginx/

echo "start php-fpm"
php-fpm7.4 -c /code/php.ini -y /code/php-fpm.conf

echo "start nginx"
nginx -c /code/nginx.conf -g "daemon off;"