#!/bin/bash

# Corrige as permissões das pastas
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/bootstrap/cache

# Inicia o servidor PHP FPM
php-fpm
