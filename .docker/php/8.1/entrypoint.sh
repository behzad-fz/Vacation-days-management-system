#!/usr/bin/env bash
cd /app

chmod 777 storage -R

if [ ! -d "/vendor" ]
then
    composer install
fi


# Start supervisord and services
exec /usr/bin/supervisord -n -c /etc/supervisord.conf
