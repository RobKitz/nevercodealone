#!/bin/bash

. bin/load-env

echo "root=${MAIL_USER}" >> /etc/ssmtp/ssmtp.conf
echo "hostname=${MAIL_USER}" >> /etc/ssmtp/ssmtp.conf
echo "mailhub=${MAIL_HUB}" >> /etc/ssmtp/ssmtp.conf
echo "AuthUser=${MAIL_USER}" >> /etc/ssmtp/ssmtp.conf
echo "AuthPass=${MAIL_PASS}" >> /etc/ssmtp/ssmtp.conf
echo "root:${MAIL_USER}:${MAIL_HUB}" > /etc/ssmtp/revaliases
echo "www-data:${MAIL_USER}:${MAIL_HUB}" >> /etc/ssmtp/revaliases

dbconn="0"
while [ $dbconn -eq 0 ]
do
    ( bin/console doctrine:schema:validate || bin/console doctrine:schema:create ) && dbconn="1"
    sleep 1
done

exec "$@"

