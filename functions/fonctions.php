<?php

function connect_db() {
    require_once("connect.php");

    $dsn = "mysql:dbname=".BASE.";host=".SERVER;
    try {
        $connexion = new PDO($dsn, USER, PASSWORD);
    } catch(PDOException $e){
        printf("Échec de la connexion : %s\n", $e->getMessage());
        exit();
    }
    return $connexion;
}

function getQuestionnaires(){
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE");
    $requete->execute();
    $questionnaires = $requete->fetchAll();
    return $questionnaires;
}

function afficherQuestionnaires(){
    $questionnaires = getQuestionnaires();
    foreach($questionnaires as $questionnaire){
        echo "<div id='Q".$questionnaire['idQuestionnaire']."' class='questionnaire'>";
        echo "<h3>".$questionnaire['nom']."</h3>";
        echo "<form action='/game.php' method='post'>";
        echo "<input type='hidden' name='questionnaire' value='".$questionnaire['idQuestionnaire']."'>";
        echo "<input type='submit' value='Jouer'>";
        echo "</form>";
        echo "</div>";
    }
}

function getClassements(){
    require_once("../classes/Classement.php");
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("select * from QUESTIONNAIRE natural join CLASSEMENT");
    $requete->execute();
    $classements = $requete->fetchAll();
    foreach($classements as $classement) {
        $listeClassements[] = new Classement($classement["idClassement"], $classement["idQuestionnaire"], $classement["nom"]);
    }
    return $listeClassements;
}

function afficherClassements(){
    $connexion_db = connect_db();
    $listeClassements = getClassements();
    foreach($listeClassements as $classement) {
        echo "<div id=\"Q".$classement->id."\" class=\"questionnaireScoreboard\">";
        echo "<h3>".$classement->nomQuestionnaire."</h3>";
        echo "<table class=\"tableau\"";
        echo "<tr>";
        echo "<th>Score</th>";
        echo "<th>Nom</th>";
        echo "</tr>";
        $requeteScore = $connexion_db->prepare("select * from SCORE natural join CLASSEMENT where idClassement=".$classement->id." order by scorePersonne desc");
        $requeteScore->execute();
        $scores = $requeteScore->fetchAll();
        foreach($scores as $score) {
            echo "<tr>";
            echo "<td>".$score["scorePersonne"]."</td>";
            echo "<td>".$score["nomPersonne"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
}

function getQuestions($idQuestionnaire){
    require_once("../classes/Question.php");
    $connexion_db = connect_db();

    $requete = $connexion_db->prepare("SELECT * FROM QUESTION WHERE idQuestionnaire = $idQuestionnaire");
    $requete->execute();
    $questions = $requete->fetchAll();

    foreach($questions as $question){
        $liste_de_questions[] = new Question($question['idQuestion'], $question['numero'], $question['question'], $question['typeQuestion'], $question['valeurQuestion'], $question['idQuestionnaire'], "a");
    }
    return $liste_de_questions;
}

function getQuestionnaire($idQuestionnaire){
    $connexion_db = connect_db();
    $questionnaire = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE WHERE idQuestionnaire = $idQuestionnaire");
    $questionnaire->execute();
    $questionnaire = $questionnaire->fetch();
    return $questionnaire;
}

function getNombreDeQuestions($idQuestionnaire){
    $connexion_db = connect_db();
    $nombreDeQuestions = $connexion_db->prepare("SELECT COUNT(*) FROM QUESTION WHERE idQuestionnaire = $idQuestionnaire");
    $nombreDeQuestions->execute();
    $nombreDeQuestions = $nombreDeQuestions->fetch();
    return $nombreDeQuestions[0];
}

function affichageQuestions($idQuestionnaire){
    $connexion_db = connect_db();
    $questionnaire = getQuestionnaire($idQuestionnaire);
    $liste_de_questions = getQuestions($idQuestionnaire);
    $nombre_de_question = getNombreDeQuestions($idQuestionnaire);
    echo "<h1>".$questionnaire['nom']."</h1>";

    echo "<form id='form-game' action='/resultat.php' method='POST'>";
    echo "<input type='hidden' name='questionnaire' value='".$idQuestionnaire."'>";
    echo "<h2 class='numQuestionActuelle'>Question 1/".$nombre_de_question."</h2>";
    foreach($liste_de_questions as $question){
        $question->affichage($connexion_db);
    }
    echo "<input type='submit' id='fini' value='Enregistrer les réponses'>";
    echo "</form>";
    echo "<button id='suivant' onclick='questionSuivante()'>Suivant</button>";
}

function getReponseQuestion($idQuestion){
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("SELECT * FROM REPONSE WHERE idQuestion = $idQuestion");
    $requete->execute();
    $reponses = $requete->fetchAll();
    return $reponses;
}

function getReponsesListesQuestions($liste_de_questions) {
    $connexion_db = connect_db();
    foreach($liste_de_questions as $question){
        $id_question = $question->id;
        $reponses_bonnes = $connexion_db->prepare("SELECT * FROM REPONSE WHERE idQuestion = $id_question AND estBonne = true");
        $reponses_bonnes->execute();
        $reponses_bonnes = $reponses_bonnes->fetchAll();
        # on mets les réponses bonnes dans un tableau qu'on va mettre dans la question
        foreach($reponses_bonnes as $reponse){
            $question->addReponse(new Reponse($reponse['idReponse'], $reponse['reponse']));
        }
    }
    return $liste_de_questions;
}

function getReponseUsers($liste_de_questions,$nombre_de_question){
    $reponse_utilisateur = array();
    for ($i = 0; $i < $nombre_de_question; $i++){
        $num_question = $liste_de_questions[$i]->getNumero();
        $type_question = $liste_de_questions[$i]->getTypeQuestion();
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
    return $reponse_utilisateur;
}

function gererResultat($idQuestionnaire){
    require_once("../classes/Question.php");
    require_once("../classes/Reponse.php");
    
    // LES VARIABLES SCORES
    $score_utilisateur = 0;
    $score_max = 0;


    # RECUPERATION DES QUESTIONS
    $liste_de_questions = getQuestions($idQuestionnaire);
    $nombre_de_question = getNombreDeQuestions($idQuestionnaire);

    # RECUPERATION DES REPONSES
    $liste_de_questions_avecRep = getReponsesListesQuestions($liste_de_questions);


    # CALCUL DU SCORE MAX
    foreach($liste_de_questions as $question){
        $score_max += $question->valeurQuestion;
    }

    # RECUPERATION DES REPONSES UTILISATEUR
    $reponse_utilisateur = getReponseUsers($liste_de_questions_avecRep,$nombre_de_question);

    # VERIFICATION DES REPONSES
    $score_utilisateur = affichageResultat($nombre_de_question,$liste_de_questions_avecRep,$reponse_utilisateur,$score_utilisateur,$score_max);

    return $score_utilisateur;
}

function affichageResultat($nombre_de_question,$liste_de_questions,$reponse_utilisateur,$score_utilisateur,$score_max) {
    echo "<div class='questions'>";
    for ($i = 1 ; $i <= $nombre_de_question ; $i++){
        echo "<div id =q".$i." class = question>";

        echo "<h3>Question ".$i." : ".$liste_de_questions[$i-1]->getQuestion()."</h3>";


        $score_utilisateur = verifieResultat($liste_de_questions[$i-1]->getTypeQuestion(),$reponse_utilisateur[$i],$liste_de_questions[$i-1],$score_utilisateur);
        echo "</div>";
    }
    echo "</div>";
    echo "<div class='score'>Votre score est de ".$score_utilisateur."/".$score_max."</div>";

    return $score_utilisateur;
}

function verifieResultat($type_question,$reponse_utilisateur,$question,$score_utilisateur) {
    require_once("affichage.php");
    if ($type_question == "date" or $type_question == "text" or $type_question == "number") {
        if ($reponse_utilisateur == $question->getReponse()[0]->getReponse()) {
            bonneReponse($question->getReponse()[0]->getReponse());
            $score_utilisateur += $question->getValeurQuestion();
        } else {
            mauvaiseReponse($question->getReponse()[0]->getReponse());
        }
    } else if ($type_question == "radio") {
        if ($reponse_utilisateur == $question->getReponse()[0]->getID()) {
            bonneReponse($question->getReponse()[0]->getReponse());
            $score_utilisateur += $question->getValeurQuestion();
        } else {
            mauvaiseReponse($question->getReponse()[0]->getReponse());
        }
    } else if ($type_question == "checkbox") {
        $bonne_reponse = true;
        $reponse_question = $question->getReponse();
        // COMPARAISON DES DEUX TABLEAUX
        // si la longueur des deux est différente
        if (count($reponse_question) != count($reponse_utilisateur)) {
            $bonne_reponse = false;
        } else {
            // on parcourt les deux tableaux
            for ($i = 0; $i < count($reponse_question); $i++) {
                // si la reponse de l'utilisateur n'est pas dans la liste des reponses de la question
                if (!in_array($reponse_question[$i]->getID(), $reponse_utilisateur)) {
                    $bonne_reponse = false;
                }
            }
        }
        if ($bonne_reponse) {
            $reponses_affichage = "";
            for ($i = 0; $i < count($reponse_question); $i++) {
                if ($i == count($reponse_question) - 1) {
                    $reponses_affichage .= $reponse_question[$i]->getReponse();
                } else {
                    $reponses_affichage .= $reponse_question[$i]->getReponse() . ", ";
                }
            }
            bonneReponse($reponses_affichage);
            $score_utilisateur += $question->getValeurQuestion();
        } else {
            $reponses_affichage = "";
            for ($i = 0; $i < count($reponse_question); $i++) {
                if ($i == count($reponse_question) - 1) {
                    $reponses_affichage .= $reponse_question[$i]->getReponse();
                } else {
                    $reponses_affichage .= $reponse_question[$i]->getReponse() . ", ";
                }
            }
            mauvaiseReponse($reponses_affichage);
        }
    }
    return $score_utilisateur;
}