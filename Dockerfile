FROM registry.nevercodealone.de/nevercodealone/docker-webserver

ENV SYMFONY_APP_ENV=dev
ENV SYMFONY_APP_SECRET=insecure
ENV SYMFONY_CORS_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$
ENV SYMFONY_DATABASE_URL=mysql://user:pass@db/database

EXPOSE 80

# application setup
VOLUME /var/www/symfony
WORKDIR /var/www/symfony
COPY . /var/www/symfony

# apache setup
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite

# entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

