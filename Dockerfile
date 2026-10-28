FROM serversideup/php:8.3-fpm-nginx

ENV SSL_MODE=off
ENV NGINX_WEBROOT=/var/www/html/public
ENV PHP_OPCACHE_ENABLE=1

USER root

# Instalar extensiones necesarias de PHP para Laravel y Clever Cloud MySQL
RUN install-php-extensions pdo_mysql intl bcmath

# Copiar aplicación con el usuario www-data
COPY --chown=www-data:www-data . /var/www/html

# Asegurar directorios de almacenamiento y permisos
RUN mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cambiar al usuario www-data e instalar dependencias con Composer
USER www-data
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
