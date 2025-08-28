# Use a PHP image with Apache
FROM php:8.2-apache

# Instala extensões necessárias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos do projeto para o container
COPY . /var/www/html/

# Define permissões
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta padrão do Apache
EXPOSE 80

# Exemplo de configuração de conexão MySQL via variáveis de ambiente
ENV DB_HOST=mysql
ENV DB_USER=root
ENV DB_PASSWORD=example
ENV DB_NAME=meubanco