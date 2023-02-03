<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/resultat.css'; ?></style>
        <div class="resultat">
            <h1>Résultats</h1>
            <?php 
                require("../connexion.php");
                require("../classes/Question.php");

                $id_questionnaire = $_POST['questionnaire'];
                $requete = $connexion->prepare("SELECT * FROM QUESTION natural join REPONSE WHERE idQuestionnaire = $id_questionnaire");
                $requete->execute();
                $questions = $requete->fetchAll();
                $score = 0;
                $nb_de_qestions = count($questions);

                for ($i = 0 ; $i < $nb_de_qestions ; $i++){
                    $score_max += $questions[$i]['valeurQuestion'];
                }
                echo "<div class='questions'>";
                for ($i = 1 ; $i <= $nb_de_qestions ; $i++){
                    echo "<div id =q".$i." class = question>";
                    $liste_des_reponses_utilisateurs[] = $_POST[$i];
                    $liste_des_reponses[] = $questions[$i-1]['reponse'];

                    // affiche la question
                    echo "<h3>".$questions[$i-1]['question']."</h3>";

                    if ($liste_des_reponses_utilisateurs[$i-1] == $liste_des_reponses[$i-1]){
                        $score += $questions[$i-1]['valeurQuestion'];
                        echo "<p><span style='color:mediumseagreen'>Vous avez bien répondu à la question</span>, c'était bien : ".$liste_des_reponses[$i-1]."</p><br>";
                    } else {
                        echo "<p><span style='color:crimson'>Vous avez mal répondu à la question.</span> ". "La bonne réponse était : ".$liste_des_reponses[$i-1]."</p><br>";
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo "<p>Votre score est de : ".$score."/".$score_max."</p>";
            ?>

            <button onclick="window.location.href = 'menu.php';">Retour sur la page des questionnaires</button>
        </div>
        
    </body>
</html>