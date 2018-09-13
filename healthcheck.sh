#!/bin/bash

PID_FILE=/var/run/apache2/apache2.pid

cat $PID_FILE || exit 1

exit 0

