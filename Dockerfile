# Usar una imagen base de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilitar el módulo de Apache para reescritura de URL
RUN a2enmod rewrite

# Copiar el contenido de tu proyecto al contenedor
COPY . /var/www/html/

# Cambiar permisos y propietario de los archivos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
