#!/bin/bash
set -e

echo "Initilizing..."
whoami

cp /mnt/auto/typecho/typecho.conf /etc/nginx/sites-enabled/
chmod 777 -R /mnt/auto

echo "start nginx"
nohup nginx -c /etc/nginx/nginx.conf &

echo "start php-fpm"
php-fpm -c /usr/local/etc/php/php.ini-production -y /usr/local/etc/php-fpm.conf

while true
do
    nginx_server=`ps aux | grep nginx | grep -v grep`
    if [ ! "$nginx_server" ]; then
        echo "restart nginx ..."
        nginx -c /etc/nginx/nginx.conf
    fi
    php_fpm_server=`ps aux | grep php-fpm | grep -v grep`
    if [ ! "$php_fpm_server" ]; then
        echo "restart php-fpm ..."
        nohup php-fpm -c /usr/local/etc/php/php.ini-production -y /usr/local/etc/php-fpm.conf &
    fi
done
