# TP 1 WEB SERVICES

## Description
Ce projet est un TP réalisé dans le cadre du cours de Web Services. 

## Équipe
- [Papazian Loïc](https://github.com/Narigane3)
- [Peyronon Arno](https://github.com/Peyronon-Arno)
- [Charrier Valerian](https://github.com/valerianchar)
- [Clément Maldonado](https://github.com/ClemMLD)

# Installation
Cette installation n'utilise pas de base de données.
## Prérequis

- PHP 8.2 ou supérieur
- MySql 8.0 ou supérieur
- Composer
- API Key Brevo (pour les envois de courriels)
- Clé secrète et clé publique Stripe (pour les paiements)

## Installation
- [1. Installation basique](#installation-basique)
- [2. Installation avec Docker](#installation-avec-docker)

### Installation basique

1. Dézipper le fichier `TP1.zip` dans un dossier de votre choix.
2. Ouvrir le dossier `TP1` dans un terminal.
3. Exécuter la commande `composer install` pour installer les dépendances.
4. Exécuter la commande `cp .env.example .env` pour créer le fichier `.env`.
5. Implémenter les variables d'environnement dans le fichier `.env`.
   > Penser à modifier les variables d'environnement suivantes :
   >   - `APP_URL` (si différent de http://localhost)
   >   - `DB_HOST`
   >   - `DB_PORT`
   >   - `DB_DATABASE`
   >   - `DB_USERNAME`
   >   - `DB_PASSWORD`
   >   - `JWT_SECRET_KEY`
   >   - `JWT_TOKEN`
   >   - `STRIPE_KEY`
   >   - `STRIPE_PUBLIC_KEY`
   >   - `BREVO_API_KEY`
6. Exécuter la commande `php artisan key:generate` pour générer une clé d'application.
7. Exécuter la commande `php artisan migrate` pour créer les tables de la base de données.
8. Exécuter la commande `php artisan serve` pour démarrer le serveur.
9. Ouvrir un navigateur et accéder à l'adresse `http://0.0.0.0`
10. Vous pouvez maintenant utiliser l'application.

### Installation avec Docker

1. Dézipper le fichier `TP1.zip` dans un dossier de votre choix.
2. Ouvrir le dossier `TP1` dans un terminal.
3. Exécuter la commande `composer install` pour installer les dépendances.
4. Exécuter la commande `cp .env.example .env` pour créer le fichier `.env`.
5. Implémenter les variables d'environnement dans le fichier `.env`.
   > Penser à modifier les variables d'environnement suivant :
   >   - `JWT_SECRET_KEY`
   >   - `JWT_TOKEN`
   >   - `STRIPE_KEY`
   >   - `STRIPE_PUBLIC_KEY`
   >   - `BREVO_API_KEY`
6. Exécuter la commande `php artisan key:generate` pour générer une clé d'application.
7. Exécuter la commande `php artisant sail:install` pour installer Sail et initialiser les conteneurs Docker.
8. Exécuter la commande `./vendor/bin/sail artisan migrate` pour créer les tables de la base de données.
9. Exécuter la commande `.vendor/bin/sail up` pour démarrer le serveur ou `./vendor/bin/sail up -d` pour démarrer le
   serveur en arrière-plan.
