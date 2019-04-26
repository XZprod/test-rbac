FROM php:5.6-apache
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite && service apache2 restart
RUN docker-php-ext-install mysql
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get -y install libz-dev libmemcached-dev libmemcached11 libmemcachedutil2 build-essential && pecl install memcached-2.2.0&& echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini && pecl install memcache-2.2.7&& apt-get clean&& rm -rf /tmp/pear
#RUN docker-php-ext-install memcache
