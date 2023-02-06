<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/resultat.css'; ?></style>
        <div class="fenetreResultat">
            <div class="resultat">
                <h1>Résultats</h1>
                <?php 
                    require("../connexion.php");
                    require("../classes/Question.php");
                    require("../classes/Reponse.php");
                    require("../functions/affichage.php");

                    // LES VARIABLES SCORES
                    $score_utilisateur = 0;
                    $score_max = 0;
                    
                    // DICTIONNAIRE QUI CONTIENT LES QUESTIONS ET LES REPONSES
                    $dico_question = array();

                    // RECUPERATION DES QUESTIONS
                    $id_questionnaire = $_POST['questionnaire'];
                    $question_du_questionnaire = $connexion->prepare("SELECT * FROM QUESTION WHERE idQuestionnaire = $id_questionnaire");
                    $question_du_questionnaire->execute();
                    $question_du_questionnaire = $question_du_questionnaire->fetchAll();
                    
                    $liste_de_question_propre = array();

                    // LES METTRE EN CLASSE QUESTION
                    foreach($question_du_questionnaire as $question){
                        $id = $question['idQuestion'];
                        $numero = $question['numero'];
                        $quest = $question['question'];
                        $type = $question['typeQuestion'];
                        $score = $question['valeurQuestion'];
                        $idQuest = $question['idQuestionnaire'];
                        $reponse = array();
                        $question_classe = new Question($id, $numero, $quest, $type, $score, $idQuest, $reponse);
                        array_push($liste_de_question_propre, $question_classe);
                    }

                    // NOMBRE DE QUESTION
                    $nombre_de_question = count($liste_de_question_propre);

                    // RECUPERATION DES REPONSES
                    for ($i = 0; $i < $nombre_de_question; $i++){
                        $id_question = $liste_de_question_propre[$i]->getId();
                        $reponse_du_questionnaire = $connexion->prepare("SELECT * FROM REPONSE WHERE idQuestion = $id_question");
                        $reponse_du_questionnaire->execute();
                        $reponse_du_questionnaire = $reponse_du_questionnaire->fetchAll();
                        foreach($reponse_du_questionnaire as $reponse){
                            // si la reponse est bonne
                            if ($reponse['estBonne'] == true){
                                // on ajoute la reponse a la liste des reponses de la question
                                $liste_de_question_propre[$i]->addReponse(new Reponse($reponse['idReponse'], $reponse['reponse']));
                            }
                        }
                    }

                    // RECUPERATION DES REPONSES DE L'UTILISATEUR
                    $reponse_utilisateur = array();
                    for ($i = 0; $i < $nombre_de_question; $i++){
                        $num_question = $liste_de_question_propre[$i]->getNumero();
                        $type_question = $liste_de_question_propre[$i]->getTypeQuestion();
                        if ($type_question == "checkbox") {
                            // pour chaque reponse dans $_POST[$num_question]
                            foreach($_POST[$num_question] as $reponse){
                                // on ajoute la reponse a la liste des reponses de cette question
                                $reponse_utilisateur[$num_question][] = $reponse;
                            }
                        } else {
                            $reponse_utilisateur[$num_question] = $_POST[$num_question];
                        }
                    }

                    // CALCUL DU SCORE MAX
                    for ($i = 0; $i < $nombre_de_question; $i++){
                        $score_max += $liste_de_question_propre[$i]->getValeurQuestion();
                    }

                    // AFFICHAGE DES RESULTATS
                    echo "<div class='questions'>";
                    for ($i = 1 ; $i <= $nombre_de_question ; $i++){
                        echo "<div id =q".$i." class = question>";

                        echo "<h3>Question ".$i." : ".$liste_de_question_propre[$i-1]->getQuestion()."</h3>";
                        if ($liste_de_question_propre[$i-1]->getTypeQuestion() == "date" or $liste_de_question_propre[$i-1]->getTypeQuestion() == "text" or $liste_de_question_propre[$i-1]->getTypeQuestion() == "number") {
                            if ($reponse_utilisateur[$i] == $liste_de_question_propre[$i-1]->getReponse()[0]->getReponse()){
                                bonneReponse($liste_de_question_propre[$i-1]->getReponse()[0]->getReponse());
                                $score_utilisateur += $liste_de_question_propre[$i-1]->getValeurQuestion();
                            } else {
                                mauvaiseReponse($liste_de_question_propre[$i-1]->getReponse()[0]->getReponse());
                            }
                        } else if ($liste_de_question_propre[$i-1]->getTypeQuestion() == "radio") {
                            if ($reponse_utilisateur[$i] == $liste_de_question_propre[$i-1]->getReponse()[0]->getID()){
                                bonneReponse($liste_de_question_propre[$i-1]->getReponse()[0]->getReponse());
                                $score_utilisateur += $liste_de_question_propre[$i-1]->getValeurQuestion();
                            } else {
                                mauvaiseReponse($liste_de_question_propre[$i-1]->getReponse()[0]->getReponse());
                            }
                        } else if ($liste_de_question_propre[$i-1]->getTypeQuestion() == "checkbox") {
                            $bonne_reponse = true;
                            $reponse_question = $liste_de_question_propre[$i-1]->getReponse();
                            $reponse_utilisateur_question = $reponse_utilisateur[$i];

                            // COMPARAISON DES DEUX TABLEAUX
                            // si la longueur des deux est différente
                            if (count($reponse_question) != count($reponse_utilisateur_question)){
                                $bonne_reponse = false;
                            } else {
                                // si la longueur des deux est la même
                                // on parcours les deux
                                for ($j = 0; $j < count($reponse_question); $j++){
                                    // si la reponse de l'utilisateur n'est pas dans la liste des reponses de la question
                                    if (!in_array($reponse_question[$j]->getID(), $reponse_utilisateur_question)){
                                        $bonne_reponse = false;
                                    }
                                }
                            }
                            if ($bonne_reponse == true){
                                $reponses_affichage = "";
                                for ($j = 0; $j < count($reponse_question); $j++){
                                    $reponses_affichage .= $reponse_question[$j]->getReponse();
                                    if ($j != count($reponse_question)-1){
                                        $reponses_affichage .= ", ";
                                    }
                                }
                                bonneReponse($reponses_affichage);
                                $score_utilisateur += $liste_de_question_propre[$i-1]->getValeurQuestion();
                            } else {
                                $reponses_affichage = "";
                                for ($j = 0; $j < count($reponse_question); $j++){
                                    $reponses_affichage .= $reponse_question[$j]->getReponse();
                                    if ($j != count($reponse_question)-1){
                                        $reponses_affichage .= ", ";
                                    }
                                }
                                mauvaiseReponse($reponses_affichage);
                            }
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<div class='score'>Votre score est de ".$score_utilisateur."/".$score_max."</div>";
                ?>
                <button onclick="window.location.href = 'menu.php';">Retour sur la page des questionnaires</button>
            </div>
            <aside id="asideDroite">
                <form method="post" action="save.php">
                    <h3>Sauvegarder</h3>
                    <p>Voulez-vous enregistrer votre score ?</p>
                    <input type="hidden" name="score" value="<?php echo $score_utilisateur; ?>">
                    <input type="hidden" name="idQuestionnaire" value="<?php echo $id_questionnaire; ?>">
                    <input type="text" name="nom" placeholder="Votre nom" required pattern="[a-zA-Z]{3,}">
                    <input type="submit" name="save" value="Cliquer ici">
                </form>
                <?php 
                    if (isset($_POST['save'])){
                        echo "<p>Votre score a bien été enregistré !</p>";
                    }
                ?>
            </aside>
        </div>
    </body>
</html>