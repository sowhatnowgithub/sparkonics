FROM php:8.2.0-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    vim \
    openssl \
    libssl-dev \
    wget \
    git \
    procps \
    htop \
    libcurl4-openssl-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Clone and build OpenSwoole
RUN cd /tmp && \
    git clone https://github.com/openswoole/ext-openswoole.git && \
    cd ext-openswoole && \
    git checkout v22.0.0 && \
    phpize && \
    ./configure --enable-openssl --enable-hook-curl --enable-http2 --enable-mysqlnd && \
    make && make install && \
    cd / && rm -rf /tmp/ext-openswoole

# Enable the OpenSwoole extension
RUN echo 'extension=openswoole.so' > /usr/local/etc/php/conf.d/zzz_openswoole.ini

# Install dumb-init for proper signal handling
RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64 && \
    chmod +x /usr/local/bin/dumb-init

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# Copy application code
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www

# Create startup script
RUN echo '#!/bin/bash\n\
    cd /var/www/api && php api.php &\n\
    cd /var/www/thrds/src/phpServer && php messageServer.php &\n\
    cd /var/www/app/Scheduler && php SchedulerServer.php &\n\
    wait' > /usr/local/bin/start-services.sh && \
    chmod +x /usr/local/bin/start-services.sh

EXPOSE 1978 9501

ENTRYPOINT ["/usr/local/bin/dumb-init", "--"]
CMD ["/usr/local/bin/start-services.sh"]
