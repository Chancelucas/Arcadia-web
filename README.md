# Arcadia Web App

Arcadia Web est un projet fictif de développement d'application web pour le zoo Arcadia, situé en Bretagne, près de la forêt de Brocéliande en France. Ce projet a été créé dans le cadre d'un exercice d'apprentissage pour valider toutes les compétences requises pour le titre professionnel de Développeur Web et Web Mobile.

#### Contraintes et Besoins
En plus de devoir intégrer toutes les compétences du titre professionnel de développeur, ce projet est soumis à plusieurs contraintes spécifiques :

- Respect des valeurs écologiques : Le design de l'application doit évoquer l'écologie, en reflétant l'indépendance énergétique du zoo.
- Structure et contenu de l'application : L'application doit inclure des pages spécifiques pour la présentation des animaux, des habitats, des services, des avis des visiteurs, et des espaces réservés aux administrateurs, employés et vétérinaires.
- Gestion des utilisateurs et permissions : L'application doit gérer différents types d'utilisateurs (administrateur, employé, vétérinaire) avec des niveaux d'accès et des fonctionnalités spécifiques pour chaque rôle.
- Base de données relationnelle et NoSQL : Les données doivent être stockées de manière hybride, en utilisant des bases de données SQL pour les données structurées et NoSQL pour les statistiques et les consultations.
- Statistiques et tableau de bord : L'application doit permettre au directeur José de visualiser les consultations des animaux via un tableau de bord administrateur.
- Déploiement et documentation : Le projet doit être déployé de manière fonctionnelle et être entièrement documenté.


## Table des matières

- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Fonctionnalités](#fonctionnalités)
- [Lien du site](#Arcadia)

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [PHP](https://www.php.net/downloads) 8.2 ou supérieur
- [MySQL](https://dev.mysql.com/downloads/) 
- Un serveur web comme [Apache](https://httpd.apache.org/download.cgi) ou [Nginx](https://nginx.org/en/download.html)
- [Git](https://git-scm.com/downloads)
- [MongoDB Atlas](https://www.mongodb.com/products/platform/atlas-database)

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

3. Installation de composer :

```
composer install
```

Pour utiliser mongodb pour avoir le nombre de clic par animaux veillez bien a voir mongodb d'installer 

````
composer require mongodb/mongodb
````

Pensez a ajouter mongodb dans votre fichier php.ini de la version que vous utiliser :

```
extension=mongodb.so
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

## Arcadia

Lien du site : 
