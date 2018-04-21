FROM php:apache

ENV APP_ENV=dev
ENV APP_SECRET=insecure
ENV COR_ALLOW_ORIGIN=^https?://localhost:?[0-9]*$

ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_LOG_DIR=/var/log/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_PID_FILE=/var/run/apache2/apache2.pid

# os maintenance
RUN apt-get update \
 && apt-get dist-upgrade -y \
 && apt-get install -y \
        git \
        libzip-dev \
        sudo \
 && apt-get clean \
 && rm -rf /var/cache/apt/*
RUN docker-php-ext-install -j$(nproc) zip

# composer setup
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# project setup
WORKDIR /var/www/symfony
COPY . /var/www/symfony

# apache setup
COPY .docker/apache.conf /etc/apache2/sites-available/symfony.conf
RUN a2dissite 000-default \
 && a2ensite symfony

COPY .docker/check.sh /check.sh
RUN chmod +x /check.sh
HEALTHCHECK CMD /check.sh

COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT /entrypoint.sh

