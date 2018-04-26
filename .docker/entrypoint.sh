#!/bin/bash

if [[ $APP_ENV == 'prod' ]]
then
    COMPOSER_FLAGS='--no-dev'
fi

sudo -u www-data composer install $COMPOSER_FLAGS

/usr/sbin/apachectl -DFOREGROUND

