FROM php:8.1-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip

# Habilitar mod_rewrite y mod_headers para Apache
RUN a2enmod rewrite headers

# Crear directorio del proyecto
RUN mkdir -p /var/www/html/generador_firmas

# Establecer directorio de trabajo
WORKDIR /var/www/html/generador_firmas

# Copiar archivos del proyecto
COPY . /var/www/html/generador_firmas/

# Crear directorio para imágenes si no existe
RUN mkdir -p /var/www/html/generador_firmas/img

# Copiar configuración personalizada de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html/generador_firmas \
    && chmod -R 755 /var/www/html/generador_firmas

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
