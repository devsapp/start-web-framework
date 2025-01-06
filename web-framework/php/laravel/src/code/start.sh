#!/usr/bin/env bash
set +e

chmod -R 777 /code/mylaravel/bootstrap/cache
chmod -R 777 /code/mylaravel/storage
cd /code/mylaravel
cp .env.example .env
php artisan serve --host=0.0.0.0 --port=9000