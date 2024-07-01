#!/usr/bin/env bash

sed -i 's\${PROXY_PASS}\'$PROXY_PASS'\g' ./nginx.conf
/opt/bin/nginx -c /code/nginx.conf -g "daemon off;"
