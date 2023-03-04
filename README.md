# SAE_4.01_PHP - Application web de quizs

Cette application web est conçue pour permettre aux utilisateurs de faire des quizs et de vérifier les réponses qu'ils ont fournies. Elle est construite en utilisant PHP comme langage de programmation et MySQL comme base de données pour stocker les questions.

## Installation

1. Assurez-vous d'avoir une installation de PHP et MySQL sur votre machine. Si vous ne les avez pas installés, vous pouvez les télécharger et les installer depuis les sites officiels.

2. Téléchargez le code source de l'application à partir de notre repository Github.

3. Créez une base de données MySQL en utilisant le client MySQL de votre choix.

4. Importez le fichier "creation.sql" et "insertions.sql" dans la base de données créée à l'étape 3. Ce fichier contient les tables nécessaires pour stocker les différentes données.

5. Ouvrez le fichier "connect.php" dans le dossier "functions" et modifiez les paramètres de connexion à la base de données pour correspondre à votre installation.

## Utilisation

Une fois l'application installée, vous pouvez y accéder en lançant la commande `php -S localhost:8000` dans le dossier /views puis ouvrant un navigateur web et en entrant l'URL suivante : http://localhost:8000/home.php

L'application vous permet de :

- Passer des quizs en sélectionnant les quizs disponibles sur la page d'accueil et en répondant aux questions.

- Vérifier vos réponses en cliquant sur le bouton "Vérifier" après avoir répondu à toutes les questions.

- Afficher votre score et vos réponses correctes/incorrectes après avoir vérifié vos réponses.

- Ajouter, éditer ou supprimer des quizs et des questions en utilisant le système CRUD.

- Se connecter et se déconnecter en utilisant le système de login.

- Import/export de quizs et de questions (seulement sur linux)


## Si PHP et MySQL ne fonctionnent pas, voici les étapes à suivre :

1. Vérifier si PHP et MySQL sont installés.
2. Accéder au dossier PHP et repérer les fichiers php.ini-dev et php.ini-prod.
3. Copier le fichier php.ini-dev et le renommer en php.ini.
4. Utiliser la fonctionnalité de recherche (ctrl+f) pour trouver la section "Dynamic Extension".
5. Localiser la section "PDO MySQL" juste en dessous de cette dernière.
6. Supprimer le point-virgule qui commente cette ligne.
7. Enregistrer les modifications apportées au fichier.
8. Redémarrer le serveur.
