FROM php:8.1.1-fpm

RUN mkdir "/app"
WORKDIR /app

RUN apt-get update && apt-get install -y \
    supervisor \
    git \
    unzip \
    pkg-config \
    zlib1g-dev \
    libzip-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libicu-dev \
    g++ \
    vim \
    wget

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/UTC /etc/localtime
RUN "date"

RUN docker-php-ext-install zip sockets intl bcmath

ADD ./supervisord.conf /etc/supervisord.conf
ADD ./entrypoint.sh /var/local/entrypoint.sh

RUN chmod +x /var/local/entrypoint.sh