FROM php

RUN curl -sS https://getcomposer.org/installer | php

RUN apt-get -y update
RUN apt-get -y install zip

RUN php composer.phar require toin0u/digitalocean-v2:~2.0

RUN php composer.phar require kriswallsmith/buzz:~0.10

ADD docker-resources /scripts
