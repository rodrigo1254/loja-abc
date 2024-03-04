FROM wyveo/nginx-php-fpm:latest

# Instalar extensão pdo_sqlite
RUN apt-get update && \
    apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

COPY . /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html

RUN ln -s public html
RUN apt update; \
    apt install vim -y

EXPOSE 80