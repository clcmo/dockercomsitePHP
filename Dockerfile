#Usar o PHP com Apache como imagem base
FROM php:8.2-apache

# Instala todas as extensões necessárias do PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y libzip-dev unzip && docker-php-ext-install zip

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"
# Copia os arquivos do Composer e instala as dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copia os arquivos do projeto para o contêiner
COPY /public/ /var/www/html/
COPY /vendor/ /var/www/html/vendor/
COPY .env /var/www/.env

# Define as permissões corretas
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expõe a porta 80
EXPOSE 80

# Comando para iniciar o Apache em primeiro plano
CMD ["apache2-foreground"]