FROM registry.nevercodealone.de/nevercodealone/docker_php_dev:0.0.1

COPY ./opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9099" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

RUN usermod -u 1000 www-data