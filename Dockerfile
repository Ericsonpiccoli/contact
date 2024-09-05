# Usar a imagem base do PHP com Apache
FROM php:7.4-apache

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Configura permissões e propriedade
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor a porta 80 para o Apache
EXPOSE 80

