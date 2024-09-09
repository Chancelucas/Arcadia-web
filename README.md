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
- [MongoDB](https://www.mongodb.com/products/platform/atlas-database) MongoDB Atlas

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

```
mysql -u username -p NOM_DE_VOTRE_BDD < database/arcadia.sql
```

Remplacez username par votre nom d'utilisateur MySQL et arcadia_database par le nom de la base de données que vous avez créée.

Configuration des paramètres de connexion à la base de données :

Modifiez le fichier config.php à la racine du projet pour configurer les paramètres de connexion à la base de données :

```
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'NOM DE VOTRE BDD');
define('DB_USER', 'VOTRE USERNAME');
define('DB_PASS', 'VOTRE PASSWORD');
```

## Utilisation

Accédez à l'application en ouvrant votre navigateur et en vous rendant à l'adresse :

```http://localhost:8000```

Vous pouvez maintenant naviguer dans l'application pour explorer les fonctionnalités disponibles, telles que la visualisation des animaux, les services du zoo, et plus encore.

## Fonctionnalités

- Page d'accueil avec présentation du zoo et ses animaux.
- Menu de navigation avec accès aux services, habitats, connexion, et contact.
- Vue globale des services et habitats.
- Système de gestion des avis des visiteurs.
- Espace administrateur pour la gestion des comptes et des contenus.
- Espaces dédiés pour les employés et les vétérinaires.
