FROM registry.nevercodealone.de/nevercodealone/docker-webserver

LABEL description="Shipped application image for nevercodealone.de."
LABEL maintainer="Thomas Steinert <moenka@10forge.org>"
LABEL vendor="Never Code Alone"

ENV SYMFONY_APP_ENV=dev
ENV SYMFONY_APP_SECRET=insecure
ENV SYMFONY_CORS_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$
ENV SYMFONY_DATABASE_URL=mysql://user:pass@db/database

# No need to overwrite these values from docker-compose or cli.
# These environment variables exist only to serve apache.
ENV APP_ENV=$SYMFONY_APP_ENV
ENV APP_SECRET=$SYMFONY_APP_SECRET
ENV CORS_ALLOW_ORIGIN=$SYMFONY_CORS_ALLOW_ORIGIN
ENV DATABASE_URL=$SYMFONY_DATABASE_URL

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

# Application setup
WORKDIR /var/www/html
COPY . /var/www/html

# Apache setup
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite

