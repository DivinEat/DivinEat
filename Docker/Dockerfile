FROM php:7.2-apache

EXPOSE 80

RUN apt-get update -qy && apt-get install -y --no-install-recommends \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
