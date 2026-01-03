# Initialisation du projet.

Créer tout d'abord une Base de donnée.
Copiez le fichier '.env' en '.env.local' et renseigner les informations indiqués. Sans modifier la disposition.
(à la racine du projet)  
cp .env.local .env  
Important : Ne modifiez pas le nom des variables. Renseignez uniquement les valeurs indiquées sans changer la structure du fichier.

éxécuter les commandes, avec un terminal à la racine du projet :  
'php app/scripts/main_create.php'  
'php app/scripts/main_bdd_alim.php'  

Vérifier si dans la BD les données sont présente.

# Démarrer le serveur Web:

avec un terminal dans le dossier '/public', éxecuter la commande:  
'php -S localhost:8000'  
se rendre à l'adresse localhost sur un navigateur
# Projet : Gestion d'Association (ASCG)

Ce projet est une application PHP/MySQL développée dans le cadre d'un projet universitaire (L3). Il permet de gérer une association sportive et culturelle (sections, activités, adhérents, bénévoles, inscriptions).

Résumé des fonctionnalités
- Liste des activités avec filtres (par section, jour, créneau horaire)
- Détail d'une activité : informations, lieu, capacité et liste des inscrits
- Gestion des sections : liste, détail, bénévoles et référents
- Formulaires pour ajouter une section et ajouter une activité
- Utilisation de PDO et de requêtes préparées pour toutes les opérations BDD

Arborescence principale
- app/
	- controllers/
		- ActiviteController.php
		- SectionController.php
		- GlobalController.php
	- models/
		- Activite.php
		- Section.php
		- Lieu.php
	- views/
		- homePage.php
		- activite/
		- section/
		- partial/
	- scripts/  (scripts de création / alimentation de la BDD)
- config/
	- database.php
- public/
	- index.php  (point d'entrée)

Prérequis
- PHP 8.x
- MySQL/MariaDB
- (Optionnel) XAMPP/WAMP sur Windows

Installation & initialisation de la base
1. Configurer la connexion à la BDD dans `config/database.php`.
2. Depuis la racine du projet, exécuter les scripts d'initialisation / alimentation (les scripts présents dans `app/scripts`). Par exemple :

```powershell
php app/scripts/main_create.php
php app/scripts/main_bdd_alim.php
```

Note : certains scripts de création attendent que la base soit accessible et que les paramètres de `config/database.php` soient corrects.

Lancement du serveur (développement)
1. Ouvrir un terminal dans le dossier `public`.
2. Lancer le serveur PHP intégré :

```powershell
php -S localhost:8000
```

3. Ouvrir `http://localhost:8000` dans votre navigateur.

Routes utiles
- `/` : page d'accueil
- `/activite-liste` : liste et filtres des activités
- `/activite-detail?id=XX` : détail d'une activité (passer l'id en GET)
- `/activite-ajouter` : formulaire d'ajout d'activité
- `/section-liste` : liste des sections
- `/section-detail?cd_section=XXX` : détail d'une section
- `/section-ajouter` : formulaire d'ajout de section

Remarques techniques
- Toutes les requêtes vers la base utilisent PDO et des requêtes préparées.
- Le CSS utilise Tailwind via CDN (fichiers views incluent la dépendance).
- Les scripts d'exemples pour insérer et lier les données se trouvent dans `app/scripts/`.

Auteurs
- Morpelli Fabien
- Lodi Ylan

Si vous souhaitez que j'ajoute un schéma SQL exportable, ou que je génère un script d'import unique, dites-le et je l'ajoute.

