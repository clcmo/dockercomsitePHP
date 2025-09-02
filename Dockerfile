# Use a PHP image with Apache
FROM php:8.2-apache

# Instala extensões necessárias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia os arquivos, convertidos para o HTML, do projeto para o container
COPY public/ /var/www/html/
COPY vendor/ /var/www/html/vendor/

# Exemplo de configuração de conexão MySQL via variáveis de ambiente, estas irão para um arquivo de ambiente
COPY .env /var/www/html/.env

# Define permissões
RUN chown -R www-data:www-data /var/www/html
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponha a porta padrão do Apache: 8080
EXPOSE 8080

