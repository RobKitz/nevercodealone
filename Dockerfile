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
        iproute2 \
        libcurl4-openssl-dev \
        libxml2-dev \
        libzip-dev \
        sudo \
        vim \
 && apt-get clean \
 && rm -rf /var/cache/apt/*
RUN docker-php-ext-install -j$(nproc) curl
RUN docker-php-ext-install -j$(nproc) dom
RUN docker-php-ext-install -j$(nproc) mbstring
RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) xml
RUN docker-php-ext-install -j$(nproc) zip

# composer setup
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# codeception install
RUN curl -LsS https://codeception.com/codecept.phar -o /usr/local/bin/codecept \
 && chmod a+x /usr/local/bin/codecept

# build composer cache
WORKDIR /var/www
COPY composer.* ./
RUN chown -R www-data: .
RUN sudo -u www-data composer install \
 && rm -rf var \
 && rm -rf vendor \
 && rm -f composer.*

# project setup
WORKDIR /var/www/symfony
COPY . .
RUN chown -R www-data: .

# apache setup
COPY .docker/apache.conf /etc/apache2/sites-available/symfony.conf
RUN a2dissite 000-default \
 && a2ensite symfony
RUN a2enmod rewrite

COPY .docker/check.sh /check.sh
RUN chmod +x /check.sh
HEALTHCHECK CMD /check.sh

COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT /entrypoint.sh

