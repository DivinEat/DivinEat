FROM php:7.4.3-apache

ENV COMPOSER_HOME="/tmp" \
COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80
WORKDIR /app

RUN apt-get update -qy && \
    apt-get install -y --no-install-recommends \
    git=1:2.20.1\* \
    libicu-dev=63.1\* \
    unzip=6.0\* \
    bzip2=1.0.6\* \
    libpng-dev=1.6.36\* \
    libbz2-dev=1.0.6\* \
    libzip-dev=1.5.1\* \
    nodejs=10.15.2\* \
    npm=5.8.0\* \
    libgmp-dev=2:6.1\* \
    zip=3.0\* && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /tmp/* /var/tmp/*

RUN npm install -g yarn@1.19.1

RUN docker-php-ext-install pdo_mysql  zip  bz2  gd  gmp intl

RUN a2enmod rewrite

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
