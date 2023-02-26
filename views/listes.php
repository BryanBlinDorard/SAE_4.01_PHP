<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        
        <?php
            require_once('../functions/fonctions.php');
            if (!verifierSiIlEstConnecte()) {
                header('Location: ./home.php');
            }
            echo "<input type='button' value='Retour' onclick='window.location.href=\"/admin.php\"'>";
            echo "<h2>Les questionnaires</h2>";
            require_once("../functions/fonctions.php");
            affichageQuestinnaireListage();
        ?>
    <style><?php include '../styles/home.css'; ?></style>
    <style><?php include '../styles/menu.css'; ?></style>
    <style><?php include '../styles/listes.css'; ?></style>
    </body>
</html>