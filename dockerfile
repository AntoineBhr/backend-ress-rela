FROM php:8.2-cli

# Installez les extensions PHP requises
RUN docker-php-ext-install pdo pdo_mysql

# Installez les outils nécessaires pour Composer
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Installez Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Créez un utilisateur non root
RUN useradd -ms /bin/bash appuser

# Copiez les fichiers de l'application
COPY . /var/www

# Changez le propriétaire des fichiers
RUN chown -R appuser:appuser /var/www

# Déplacez-vous dans le répertoire de l'application
WORKDIR /var/www

# Installez les dépendances sans scripts en tant que root
RUN composer install --prefer-dist --no-scripts --no-progress

# Changez l'utilisateur pour appuser
USER appuser

# Exécutez les scripts de Composer en tant que appuser
RUN composer run-script post-install-cmd

# Exposez le port
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
