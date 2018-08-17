#!/bin/bash

rm -f .env
if [[ "$APP_ENV" = "dev" ]]; then
    echo "APP_ENV=$APP_ENV" >> .env
    echo "APP_SECRET=$APP_SECRET" >> .env
    echo "CORS_ALLOW_ORIGIN=$CORS_ALLOW_ORIGIN" >> .env
    echo "DATABASE_URL=$DATABASE_URL" >> .env
fi

chown -R www-data:www-data .

apachectl -DFOREGROUND

