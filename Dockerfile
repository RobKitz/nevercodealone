FROM composer AS composer

ARG APP_ENV=dev

COPY . /app
RUN ([[ "$APP_ENV" != "dev" ]] && composer install --no-dev --optimize-autoloader && rm -f .env) || composer install



FROM php:apache AS webserver

LABEL contributor="Thomas Steinert <moenka@10forge.org>"
LABEL description="Shipped application image for nevercodealone.de."
LABEL vendor="Never Code Alone"

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
 && apt-get dist-upgrade -y \
 && apt-get install -y \
        libzip-dev \
 && apt-get clean \
 && rm -rf /var/cache/apt \
 && rm -rf /var/lib/apt

RUN docker-php-ext-install -j$(nproc) mysqli \
 && docker-php-ext-install -j$(nproc) pdo_mysql \
 && docker-php-ext-install -j$(nproc) zip

RUN a2enmod rewrite

CMD ["/usr/sbin/apachectl", "-DFOREGROUND"]

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY php.ini /usr/local/etc/php/php.ini
COPY --chown=www-data:www-data --from=composer /app /var/www/html

