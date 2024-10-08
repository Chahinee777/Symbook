# Documentation du Site de Collection de Livres

## Introduction
Ce site de collection de livres est construit avec le framework Symfony. Il permet aux utilisateurs de gérer leur collection de livres, d'ajouter de nouveaux titres, de modifier ou de supprimer des livres existants et de consulter les détails de chaque livre.

## Fonctionnalités Principales
- **Gestion des Livres :** Ajouter, modifier et supprimer des livres dans la collection.
- **Recherche :** Rechercher des livres par titre, auteur ou genre.
- **Affichage des Détails :** Consulter les informations détaillées sur chaque livre.
- **Administration :** Accès à un panneau d'administration pour gérer les utilisateurs et les livres.

## Technologies Utilisées
- **Symfony** : Framework PHP pour le développement web.
- **MySQL** : Base de données pour le stockage des informations sur les livres.
- **Twig** : Moteur de templates pour la mise en page et le design du site.

## Installation
1. Cloner le dépôt :
   ```bash
   git clone https://github.com/Chahinee777/Symbook.git
   ```
2. Installer les dépendances :
   ```bash
   composer install
   ```
3. Configurer la base de données dans le fichier `.env`.
4. Exécuter les migrations :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
5. Lancer le serveur de développement :
   ```bash
   symfony serve
   ```

## Utilisation
- Accéder au site via `http://localhost:8000`.
- Créer un compte ou se connecter pour commencer à gérer votre collection de livres.
- Pour accéder au panneau d'administration, connectez-vous avec un compte ayant des droits d'administrateur.
