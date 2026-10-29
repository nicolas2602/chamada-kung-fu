FROM mcr.microsoft.com/devcontainers/php:8.5

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo pdo_mysql xml

WORKDIR /var/www/html