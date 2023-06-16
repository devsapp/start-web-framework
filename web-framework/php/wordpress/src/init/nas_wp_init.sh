#!/usr/bin/env bash
set +e

wget http://devsapp.functioncompute.com/devsapp/wordpress-6.2.2-zh_CN.zip -O /mnt/auto/wordpress-6.2.2-zh_CN.zip.zip
cd /mnt/auto && unzip wordpress-6.2.2-zh_CN.zip && rm /mnt/auto/wordpress-6.2.2-zh_CN.zip.zip && cd -

echo "define('AUTOMATIC_UPDATER_DISABLED', true);" >> /mnt/auto/wordpress/wp-config-sample.php

if [ "$useSqlLite" = "true" ]; then
cp /code/db.php  /mnt/auto/wordpress/wp-content/db.php
cp /code/wp-config.php /mnt/auto/wordpress/wp-config.php
fi

mkdir -p /mnt/auto/wordpress/cookies
chown -R www-data:www-data /mnt/auto/wordpress/cookies

mkdir -p /mnt/auto/wordpress/sessions
chown -R www-data:www-data /mnt/auto/wordpress/sessions

mkdir -p /mnt/auto/wordpress/wp-content/database 
chown -R www-data:www-data /mnt/auto/wordpress/wp-content/database 

chown -R www-data:www-data /mnt/auto/wordpress
chmod -R 777 /mnt/auto/wordpress