# ==============================================================================
#   Common Layer
# ==============================================================================
FROM php:8.4-fpm AS base

WORKDIR "/home/boson/bosonphp.com"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# ------------------------------------------------------------------------------
#   Install Dependencies
# ------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
      libzip-dev \
      libicu-dev \
      libpq-dev \
      unzip \
      git \
      curl \
    # 1.1 Install Composer
    && curl -sS https://getcomposer.org/installer \
       | php -- --install-dir=/usr/local/bin --filename=composer \
    # 1.2 Install PIE
    && curl -L --output /usr/bin/pie https://github.com/php/pie/releases/latest/download/pie.phar \
       && chmod +x /usr/bin/pie \
    # 1.3 Install PECL
    && pecl channel-update pecl.php.net \
    # 2.1 Install ext-intl
    && docker-php-ext-install intl \
       && docker-php-ext-enable intl \
    # 2.2 Install ext-sockets
    && docker-php-ext-install sockets \
       && docker-php-ext-enable sockets \
    # 2.3 Install ext-zip
    && docker-php-ext-install zip \
       && docker-php-ext-enable zip \
    # 2.4 Install ext-igbinary \
    && pecl install igbinary \
       && docker-php-ext-enable igbinary \
    # 2.5 Install ext-opcache
    && docker-php-ext-install opcache \
    # 2.6 Install ext-pdo_pgsql
    && docker-php-ext-install pdo_pgsql \
       && docker-php-ext-enable pdo_pgsql \
    # 2.7 Install ext-apcu
    && pie install apcu/apcu \
      && docker-php-ext-enable apcu \
    # 3.1 Cleanup Dependencies
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
       && ln -sf /usr/share/zoneinfo/Etc/UTC /etc/localtime \
    # 4.1 Create User
    && useradd -u 1000 -m boson

# ------------------------------------------------------------------------------
#   Common Configuration
# ------------------------------------------------------------------------------

COPY --chown=root:root ./docker/php/conf.d/php.ini "$PHP_INI_DIR/98-php.ini"

# ------------------------------------------------------------------------------
#   Common Entrypoint
# ------------------------------------------------------------------------------

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


# ==============================================================================
#   Dev Layer
# ==============================================================================
FROM base AS dev

# ------------------------------------------------------------------------------
#   Dev Configuration
# ------------------------------------------------------------------------------

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --chown=root:root ./docker/php/conf.d/php.dev.ini "$PHP_INI_DIR/99-php.dev.ini"

# ------------------------------------------------------------------------------
#   Dev Entrypoint
# ------------------------------------------------------------------------------

COPY ./docker/php/entrypoint.dev.sh /usr/local/bin/entrypoint.dev.sh
RUN chmod +x /usr/local/bin/entrypoint.dev.sh

# ------------------------------------------------------------------------------
#   Ready
# ------------------------------------------------------------------------------

USER boson

ENTRYPOINT ["/usr/local/bin/entrypoint.dev.sh"]
