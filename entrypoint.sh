#!/bin/bash

[ -n "$APP_DEBUG_FILE" ] && export APP_DEBUG="$(cat $APP_DEBUG_FILE)"
[ -n "$APP_ENV_FILE" ] && export APP_ENV="$(cat $APP_ENV_FILE)"
[ -n "$APP_SECRET_FILE" ] && export APP_SECRET="$(cat $APP_SECRET_FILE)"
[ -n "$CORS_ALLOW_ORIGIN_FILE" ] && export CORS_ALLOW_ORIGIN="$(cat $CORS_ALLOW_ORIGIN_FILE)"
[ -n "$DATABASE_URL_FILE" ] && export DATABASE_URL="$(cat $DATABASE_URL_FILE)"

exec "$@"

