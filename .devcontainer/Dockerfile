FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install additional PHP extensions needed for WordPress
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install --no-install-recommends \
        mysql-client \
        default-mysql-client \
        zip \
        unzip \
        git \
        curl \
        wget \
        vim \
    && docker-php-ext-install \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        exif \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install WordPress CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/wp-cli/v2.8.1/utils/wp-completion.bash \
    && curl -O https://raw.githubusercontent.com/wp-cli/wp-cli/v2.8.1/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Install Playwright
RUN npm install -g playwright @playwright/test

# Set up development environment
WORKDIR /workspaces/tour-operator

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install

# Copy composer files and install dependencies
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader

EXPOSE 3000 8000 8080 9000