FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    bash \
    sudo \
    htop \
    unzip \
    git \
    curl \
    supervisor \
    cron \
    libpq-dev

RUN printf "\n" | pecl install redis

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mbstring zip exif pcntl pdo_pgsql pgsql
RUN docker-php-ext-install opcache

RUN docker-php-ext-install ftp

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Copy PHP config
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN echo "access.log = /dev/null" >> /usr/local/etc/php-fpm.d/www.conf

# Setup xdebug
ENV XDEBUG_SESSION 'DateSpark'

RUN touch /var/log/xdebug.log
RUN sudo chmod 777 /var/log/xdebug.log

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.1/install.sh | bash && \
    export NVM_DIR="$HOME/.nvm" && \
    [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh" && \
    nvm install --lts

RUN . ~/.bashrc

# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


EXPOSE 9000
CMD ["php-fpm"]
