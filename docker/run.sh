#!/bin/sh

cd /var/www/html

php artisan migrate --force
php artisan optimize

/usr/bin/supervisord -c /etc/supervisord.conf
