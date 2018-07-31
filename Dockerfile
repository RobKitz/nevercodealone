FROM registry.nevercodealone.de/nevercodealone/docker-webserver

ENV APP_ENV=dev
ENV APP_SECRET=insecure
ENV CORS_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$

# application setup
WORKDIR /var/www/symfony
COPY . /var/www/symfony
RUN chown -R www-data: .
VOLUME /var/www/symfony

# apache setup
COPY apache.conf /etc/apache2/sites-available/symfony.conf
RUN a2dissite 000-default \
 && a2ensite symfony \
 && a2enmod rewrite

EXPOSE 80
ENTRYPOINT ["/usr/sbin/apachectl", "-DFOREGROUND"]

