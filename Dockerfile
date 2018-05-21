FROM registry.nevercodealone.de/nevercodealone/docker-webserver

ENV APP_ENV=dev
ENV APP_SECRET=insecure
ENV CORS_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$

# build composer cache
WORKDIR /var/www/.composer
RUN chown -R www-data .
WORKDIR /tmp/composer
COPY composer.* ./
RUN chown -R www-data: .
RUN sudo -u www-data composer install \
 && rm -rf /tmp/composer

# apache setup
COPY apache.conf /etc/apache2/sites-available/symfony.conf
RUN a2dissite 000-default \
 && a2ensite symfony \
 && a2enmod rewrite

# entrypoint
COPY docker-entrypoint.sh /docker-entrypoint.sh

# project setup
WORKDIR /var/www/symfony
COPY . .
RUN chown -R www-data: .
VOLUME /var/www/symfony

EXPOSE 80
ENTRYPOINT ["/docker-entrypoint.sh"]