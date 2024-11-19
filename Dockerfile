# Usar la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalar las extensiones necesarias para PHP (PDO, PDO MySQL, y MySQLi)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar los archivos de la API al directorio Apache
COPY . /var/www/html/

# Copiar la configuración personalizada de Apache
COPY my-apache-config.conf /etc/apache2/sites-available/000-default.conf

# Exponer el puerto 80 para acceso web
EXPOSE 80

# Habilitar mod_rewrite (por si necesitas URLs amigables)
RUN a2enmod rewrite
