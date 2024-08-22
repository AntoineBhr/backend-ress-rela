# Utilisez l'image PHP officielle avec FPM
FROM php:8.2-fpm

# Installez les extensions PHP requises
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    g++ \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Installez Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créez un utilisateur non root
RUN useradd -ms /bin/bash appuser

# Copiez les fichiers de l'application
COPY . /var/www/html

# Changez le propriétaire des fichiers
RUN chown -R appuser:appuser /var/www/html

# Déplacez-vous dans le répertoire de l'application
WORKDIR /var/www/html

# Installez les dépendances PHP
RUN composer install --prefer-dist --no-progress --no-scripts

# Exposez le port pour PHP-FPM
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
