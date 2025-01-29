#!/bin/sh

cd /var/www

php artisan cache:clear
php artisan route:cache

#php artisan short-schedule:run

* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1

/usr/bin/supervisord -c /etc/supervisord.conf
