# syntax=docker/dockerfile:1

FROM php:8.3.6-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client \
    netcat-openbsd \
    ghostscript \
    libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer diretamente no container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurações do Apache
RUN a2enmod rewrite
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Configuração do diretório
WORKDIR /var/www/html

# Copia arquivos composer para otimizar cache

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --optimize-autoloader || true

COPY . .

RUN composer dump-autoload --optimize


# Cria e ajusta permissões
#RUN mkdir -p \
#    /var/www/html/storage/framework/views \
#    /var/www/html/storage/framework/cache \
#    /var/www/html/storage/framework/sessions \
#    /var/www/html/storage/logs \
#    /var/www/html/bootstrap/cache
#
#RUN chown -R www-data:www-data /var/www/html \
#    && find /var/www/html -type d -exec chmod 755 {} \; \
#    && find /var/www/html -type f -exec chmod 644 {} \; \
#    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
#

RUN mkdir -p \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/logs \
    /var/www/html/storage\
    /var/www/html/bootstrap/cache \
  && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
  && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Comentar a linha que bloqueia PDF no policy.xml
RUN sed -i 's/<policy domain="coder" rights="none" pattern="PDF" \/>/<!-- <policy domain="coder" rights="none" pattern="PDF" \/> -->/' /etc/ImageMagick-6/policy.xml

# Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Healthcheck
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/ || exit 1
