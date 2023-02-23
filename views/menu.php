<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <input type="button" value="Accueil" onclick="window.location.href='/home.php'">
        
        <h2>Choisissez un questionnaire</h2>
        <div class="menu">
        <?php 
            // Affichage des questionnaires
            require_once("../functions/fonctions.php");
            afficherQuestionnaires();
        ?>
        </div>
        <?php
            if (isset($_POST['save'])){
                echo "<p class='messageScore'>Votre score a bien été enregistré</p>";
            }
        ?>
        
    </body>
</html>