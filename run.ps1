# Exécute `composer install` pour installer les dépendances
Write-Host "Installation des dépendances avec Composer..."
composer install

# Démarre le serveur Symfony
Write-Host "Démarrage du serveur Symfony..."
symfony server:start

# Définir une fonction pour arrêter le serveur Symfony
function Stop-SymfonyServer {
    Write-Host "Arrêt du serveur Symfony..."
    symfony server:stop
}

# S'assurer que le serveur Symfony est arrêté lorsque le script est interrompu
try {
    Write-Host "Le serveur Symfony est actif. Fermez cette fenêtre ou appuyez sur Ctrl+C pour l'arrêter."
    # Affiche les logs en continu
    Get-Content -Path "var/log/dev.log" -Wait
} finally {
    Stop-SymfonyServer
}
