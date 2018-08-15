#!/bin/bash

echo -n "" > .env
for i in $(env | grep -E "^SYMFONY_"); do
    echo "${i#SYMFONY_}" >> .env
    echo "${i#SYMFONY_}" >> /etc/environment
done
sed -i -E 's/^(.*)=(.*)$/\1="\2"/g' /etc/environment
source /etc/environment
#chown -R www-data: .

apachectl -DFOREGROUND

