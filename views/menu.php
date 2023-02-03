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
        
        <?php
            require("../connexion.php");
            $connexion_db = $connexion;
            $requete = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE");
            $requete->execute();
            $questionnaires = $requete->fetchAll();
        ?>

        <h2>Choisissez un questionnaire</h2>
        <div class="menu">
        <?php 
            foreach($questionnaires as $questionnaire){
                echo "<div id='Q".$questionnaire['idQuestionnaire']."' class='questionnaire'>";
                echo "<h3>".$questionnaire['nom']."</h3>";
                echo "<form action='/game.php' method='post'>";
                echo "<input type='hidden' name='questionnaire' value='".$questionnaire['idQuestionnaire']."'>";
                echo "<input type='submit' value='Jouer'>";
                echo "</form>";
                echo "</div>";
            }
        ?>
        </div>
        
    </body>
</html>