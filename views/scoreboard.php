<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/scoreboard.css'; ?></style>
        <input type="button" value="Accueil" onclick="window.location.href='/home.php'">
        <h1>Voici les Scores</h1>
        <div class="scoreboard">
            <?php
                require_once("../functions/fonctions.php");
                afficherClassements();
            ?>        
        </div>
    </body>
</html>