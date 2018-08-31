#!/bin/bash

. bin/load-env
sleep 10
bin/console doctrine:schema:validate || bin/console doctrine:schema:create

exec "$@"

