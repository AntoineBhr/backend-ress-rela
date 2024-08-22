FROM php:8.2-cli

# Installez les extensions PHP requises
RUN docker-php-ext-install pdo pdo_mysql

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

# Exécutez la première partie de l'installation sans scripts en tant que root
RUN composer install --prefer-dist --no-scripts --no-progress

# Changer l'utilisateur pour appuser
USER appuser

# Exécutez les scripts manuellement en tant que appuser
RUN composer run-script post-install-cmd

# Exposez le port
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
