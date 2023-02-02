<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <div class="resultat">
            <h1>Resultat</h1>
            <?php 
                require("../connexion.php");
                require("../classes/Question.php");
                $connexion_db = $connexion;

                $id_questionnaire = $_POST['questionnaire'];
                $requete = $connexion_db->prepare("SELECT * FROM question natural join reponse WHERE idQuestionnaire = $id_questionnaire");
                $requete->execute();
                $questions = $requete->fetchAll();
                $score = 0;
                $nb_de_qestions = count($questions);

                for ($i = 1 ; $i <= $nb_de_qestions ; $i++){
                    $liste_des_reponses_utilisateurs[] = $_POST[$i];
                    $liste_des_reponses[] = $questions[$i-1]['reponse'];

                    if ($liste_des_reponses_utilisateurs[$i-1] == $liste_des_reponses[$i-1]){
                        $score += $questions[$i-1]['valeurQuestion'];
                        echo "Vous avez bien répondu à la question ".$i." : ".$questions[$i-1]['question']."<br>";
                    } else {
                        echo "Vous avez mal répondu à la question ".$i." : ".$questions[$i-1]['question']." La bonne réponse était : ".$liste_des_reponses[$i-1]."<br>";
                    }
                }

            ?>
        </div>
        
    </body>
</html>