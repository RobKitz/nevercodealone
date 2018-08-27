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
        jq \
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



FROM webserver AS toolbox

LABEL description="Shipped toolboximage for nevercodealone.de."

ARG RANCHER_CLI_VERSION=0.6.9
ARG RANCHER_CLI_URL=https://github.com/rancher/cli/releases/download/v$RANCHER_CLI_VERSION/rancher-linux-amd64-v$RANCHER_CLI_VERSION.tar.gz
ARG RANCHER_COMPOSE_VERSION=0.12.4
ARG RANCHER_COMPOSE_URL=https://github.com/rancher/rancher-compose/releases/download/v${RANCHER_COMPOSE_VERSION}/rancher-compose-linux-amd64-v${RANCHER_COMPOSE_VERSION}.tar.gz

RUN curl -sSL "$RANCHER_CLI_URL" | tar -xzp -C /usr/local/bin/ --strip-components=2 \
 && curl -sSL "$RANCHER_COMPOSE_URL" | tar -xzp -C /usr/local/bin/ --strip-components=2

CMD []

