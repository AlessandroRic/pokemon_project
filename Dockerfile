# Use uma imagem base oficial do PHP com Apache
FROM php:8.1-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    opcache \
    zip

# Instalar Composer manualmente
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . .

# Habilitar módulos do Apache
RUN a2enmod rewrite

# Copiar configuração do Virtual Host
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor a porta do Apache
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["apache2-foreground"]
