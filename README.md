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

