#!/bin/bash

set -e

for i in $(env | grep -E "^SYMFONY_"); do
    echo "${i#SYMFONY_}" >> .env
done
chown -R www-data: .

apachectl -DFOREGROUND

