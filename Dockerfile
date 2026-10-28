FROM richarvey/nginx-php-fpm:3.1.6

# Copiar código de la aplicación
COPY . /var/www/html

# Configuraciones de servidor para Laravel en Render
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Permisos requeridos por Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto expuesto por Render
ENV PORT 10000
EXPOSE 10000
