FROM php:8.2.0-cli

# Install dependencies including libcurl dev headers
RUN apt-get update && apt-get install -y \
    vim \
    openssl \
    libssl-dev \
    wget \
    git \
    procps \
    htop \
    libcurl4-openssl-dev  # 👈 REQUIRED for curl support

# Clone and build OpenSwoole
RUN cd /tmp && git clone https://github.com/openswoole/ext-openswoole.git && \
    cd ext-openswoole && \
    git checkout v22.0.0 && \
    phpize && \
    ./configure --enable-openssl --enable-hook-curl --enable-http2 --enable-mysqlnd && \
    make && make install

# Enable the extension
RUN echo 'extension=openswoole.so' > /usr/local/etc/php/conf.d/zzz_openswoole.ini

# Install dumb-init
RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64 && \
    chmod +x /usr/local/bin/dumb-init

# Clean up
RUN apt-get autoremove -y && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
COPY . .

# Install composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --no-interaction --prefer-dist && \
    composer dump-autoload --optimize

WORKDIR /var/www/api

EXPOSE 1978

ENTRYPOINT ["/usr/local/bin/dumb-init", "--"]
CMD ["php", "api.php"]
