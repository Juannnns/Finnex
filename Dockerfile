FROM richarvey/nginx-php-fpm:3.1.6

# Copiar el código del proyecto
COPY . /var/www/html

# Copiar configuración de Nginx para Laravel
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-available/default.conf

# Variables de entorno
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Crear carpetas requeridas y otorgar permisos
RUN mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependencias de PHP (vendor/autoload.php)
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

EXPOSE 80 10000
