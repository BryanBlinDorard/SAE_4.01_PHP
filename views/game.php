<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <script><?php include '../js/game.js'; ?></script>
    
    <body onload="premiereQuestion()">
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/game.css'; ?></style>
        <input type="button" value="Menu questionnaire" onclick="window.location.href='/menu.php'">
        
        <?php
            require("../connexion.php");
            require("../classes/Question.php");
            $connexion_db = $connexion;
            $id_questionnaire = $_POST['questionnaire'];
            
            $requete = $connexion_db->prepare("SELECT * FROM question WHERE idQuestionnaire = $id_questionnaire");
            $requete->execute();
            $questions = $requete->fetchAll();

            $questionnaire = $connexion_db->prepare("SELECT * FROM questionnaire WHERE idQuestionnaire = $id_questionnaire");
            $questionnaire->execute();
            $questionnaire = $questionnaire->fetch();

            foreach ($questions as $question){
                $liste_de_questions[] = new Question($question['idQuestion'], $question['numero'], $question['question'], $question['typeQuestion'], $question['valeurQuestion'], $question['idQuestionnaire'],"");
            }
        ?>
        
        <div class="game">
            <?php
                echo "<h2>".$questionnaire['nom']."</h2>";

                echo "<form id='form-game' action='/resultat.php' method='POST'>";
                echo "<input type='hidden' name='questionnaire' value='".$id_questionnaire."'>";
                foreach($liste_de_questions as $question){
                    $question->affichage();
                }
                echo "<input type='submit' id='fini' value='Enregistrer les réponses'>";
                echo "</form>";
                echo "<button id='suivant' onclick='questionSuivante()'>Suivant</button>";
            ?>
    </body>
</html>