FROM registry.nevercodealone.de/nevercodealone/docker-webserver

LABEL description="Shipped application image for nevercodealone.de."
LABEL maintainer="Thomas Steinert <moenka@10forge.org>"
LABEL vendor="Never Code Alone"

ENV APP_ENV=dev
ENV APP_SECRET=insecure
ENV CORS_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$
ENV DATABASE_URL=mysql://user:pass@db/database

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

# Application setup
WORKDIR /var/www/html
COPY . /var/www/html

# Apache setup
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite

