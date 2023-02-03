# SAE_web_php

## Si php + Mysql ne marche pas
1. être sur d'avoir php et mysql d'installé
2. aller dans le dossier php et trouver les 2 fichiers php.ini-dev et php.ini-prod
3. copie php.ini-dev et le renommer en php.ini
4. faire ctrl+f et chercher Dynamic Extension
5. descendre jusqu'a PDO mysql (c'est juste en dessous)
6. enlever le ; (qui commente en gros la ligne)
7. save le fichier
8. relance le serv 