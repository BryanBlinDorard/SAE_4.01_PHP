<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <style><?php include '../styles/edit.css'; ?></style>
        
        <?php
            require_once("../functions/fonctions.php");
            
            echo "<h2>Création du questionnaire</h2>";
            echo "<form action='saveNewQuestionnaire.php' method='post'>";
            
            echo "<div class='nomQuestionnaire'>";
            echo "<label for='name'>Nom du questionnaire</label>";
            echo "<input type='text' name='name' id='name' required>";
            echo "<input type='submit' value='Valider'>";
            echo "</div>";

            // ajout du bouton de validation

            echo "</form>";
            
        ?>
    </body>
</html>