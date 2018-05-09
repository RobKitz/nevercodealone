#!/bin/bash

if [[ $APP_ENV == 'prod' ]]; then
    COMPOSER_FLAGS='--no-dev'
fi

sudo -u www-data composer install $COMPOSER_FLAGS

if [[ $APP_ENV == 'dev' ]]; then
#    sleep 5
#    bin/console doctrine:schema:create
    /usr/sbin/apachectl start
else
    /usr/sbin/apachectl -DFOREGROUND
fi

