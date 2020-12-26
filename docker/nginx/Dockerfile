FROM ubuntu:18.04
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y && apt-get install -y nginx

RUN useradd -ms /bin/bash nginxuser

RUN sed -i 's/user www-data/user nginxuser/g' /etc/nginx/nginx.conf

ADD ./sites-enabled /etc/nginx/sites-enabled


CMD exec nginx -g 'daemon off;'