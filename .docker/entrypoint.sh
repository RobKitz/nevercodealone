#!/bin/bash

if [[ $APP_ENV == 'prod' ]]
then
    COMPOSER_FLAGS='--no-dev'
fi

composer install $COMPOSER_FLAGS
chown -R www-data: /var/www/symfony

/usr/sbin/apachectl -DFOREGROUND

