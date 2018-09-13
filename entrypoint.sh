#!/bin/bash

. bin/load-env

dbconn="0"
while [ $dbconn -eq 0 ]
do
    ( bin/console doctrine:schema:validate || bin/console doctrine:schema:create ) && dbconn="1"
    sleep 1
done

exec "$@"

