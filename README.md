# Arcadia Web

Bienvenue sur le projet fuctif **Arcadia**, une application web pour le zoo Arcadia située en Bretagne, en France. Ce projet vise à offrir une plateforme permettant aux visiteurs de visualiser les animaux, leurs états, les services disponibles et les horaires du zoo. 

## Table des matières

- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Fonctionnalités](#fonctionnalités)
- [Contribuer](#contribuer)

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [PHP](https://www.php.net/downloads) 8.2 ou supérieur
- [MySQL](https://dev.mysql.com/downloads/) 
- Un serveur web comme [Apache](https://httpd.apache.org/download.cgi) ou [Nginx](https://nginx.org/en/download.html)
- [Git](https://git-scm.com/downloads)
- [NoSQL] (https://www.mongodb.com/products/platform/atlas-database) MongoDB Atlas

## Installation

1. **Clonez le dépôt sur votre machine locale :**

   Ouvrez votre terminal et exécutez la commande suivante :

   ```
   git clone https://github.com/Chancelucas/Arcadia-web.git
   cd Arcadia-web
   ```
   
2. **Démarrez le serveur local :**

Assurez-vous que votre serveur web (Apache ou Nginx) est correctement configuré pour pointer vers le dossier du projet cloné. Vous pouvez également utiliser le serveur de développement PHP intégré :

```php -S localhost:8000```

3. Créer et Configurer la Base de Données :

Créez une nouvelle base de données MySQL et MongoDB.
Importez le fichier SQL fourni dans le dépôt (database/arcadia.sql) pour créer les tables nécessaires.
Exemple de commande pour importer le fichier SQL :

bash
Copier le code
mysql -u username -p arcadia_database < database/arcadia.sql
Remplacez username par votre nom d'utilisateur MySQL et arcadia_database par le nom de la base de données que vous avez créée.

Configuration des paramètres de connexion à la base de données :

Modifiez le fichier config.php à la racine du projet pour configurer les paramètres de connexion à la base de données :

php
Copier le code
```
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'arcadia_database');
define('DB_USER', 'username');
define('DB_PASS', 'password');
```
Remplacez arcadia_database, username et password par vos informations.

Utilisation
Accédez à l'application en ouvrant votre navigateur et en vous rendant à l'adresse :

arduino
Copier le code
http://localhost:8000
Vous pouvez maintenant naviguer dans l'application pour explorer les fonctionnalités disponibles, telles que la visualisation des animaux, les services du zoo, et plus encore.

Fonctionnalités
Page d'accueil avec présentation du zoo et ses animaux.
Menu de navigation avec accès aux services, habitats, connexion, et contact.
Vue globale des services et habitats.
Système de gestion des avis des visiteurs.
Espace administrateur pour la gestion des comptes et des contenus.
Espaces dédiés pour les employés et les vétérinaires.
Contribuer
Si vous souhaitez contribuer à ce projet, veuillez suivre les étapes ci-dessous :

Forkez le projet.
Créez une branche pour votre fonctionnalité (git checkout -b feature/ma-fonctionnalité).
Commitez vos modifications (git commit -m 'Ajoute une nouvelle fonctionnalité').
Poussez vos commits (git push origin feature/ma-fonctionnalité).
Ouvrez une Pull Request.
Merci de votre contribution !
