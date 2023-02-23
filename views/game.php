<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Quyz</title>
    </head>
    <script><?php include '../js/game.js'; ?></script>
    
    <body onload="premiereQuestion()">
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/game.css'; ?></style>
        <input type="button" value="Menu questionnaire" onclick="window.location.href='/menu.php'">
        
        
        <div class="game">
            <?php
                require_once("../functions/fonctions.php");
                $id_questionnaire = $_POST['questionnaire'];
                affichageQuestions($id_questionnaire);
            ?>
        </div>
    </body>
</html>