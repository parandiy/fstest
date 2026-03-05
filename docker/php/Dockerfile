FROM php:8.3-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]