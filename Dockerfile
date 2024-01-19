# Use a imagem oficial do PHP 8.0 com FPM
FROM php:8.0-fpm

# Atualize a lista de pacotes e instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    git \
    unzip \
    zip

# Configure e instale a extensão pdo_pgsql
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

# Configurar e instalar a extensão GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Limpe a lista de pacotes para reduzir o tamanho da imagem
RUN rm -rf /var/lib/apt/lists/* 

# Copie o Composer para o container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o projeto Laravel para o container
COPY . /var/www/html/

# Instale as dependências do Composer e otimize o autoloader
RUN composer install --optimize-autoloader
RUN composer dump-autoload --optimize --classmap-authoritative

# Copia o script de entrada para o container
COPY entrypoint.sh /entrypoint.sh

# Define o script de entrada
ENTRYPOINT ["/entrypoint.sh"]
