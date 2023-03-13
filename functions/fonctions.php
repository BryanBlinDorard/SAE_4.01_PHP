<?php

function connect_db() {
    /** Permet d'avoir la connexion db 
     *  
     *  @return PDO $connexion
     */
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
    /** Récupère tous les questionnaires 
     *  @return array(Questionnaire)
     */
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE ");
    $requete->execute();
    $questionnaires = $requete->fetchAll();
    return $questionnaires;
}

function getQuestionnairesAvecQuestions(){
    /** Récupère tous les questionnaires avec les questions 
     *  @return array(Questionnaire)
     */
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE WHERE idQuestionnaire IN (SELECT idQuestionnaire FROM QUESTION)");
    $requete->execute();
    $questionnaires = $requete->fetchAll();
    return $questionnaires;
}

function afficherQuestionnaires(){
    /** Affiche tous les questionnaires 
     *  @return void
     */
    $questionnaires = getQuestionnairesAvecQuestions();
    // si il n'y a pas de questionnaire on affiche un message
    if(empty($questionnaires)) {
        echo "<p>Il n'y a pas de questionnaire pour le moment</p>";
    } else {
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
}

function getClassements(){
    /** Récupère tous les classements
     *  @return void
     */
    require_once("../classes/Classement.php");
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("select * from QUESTIONNAIRE natural join CLASSEMENT");
    $requete->execute();
    $classements = $requete->fetchAll();
    $listeClassements = array();
    foreach($classements as $classement) {
        $listeClassements[] = new Classement($classement["idClassement"], $classement["idQuestionnaire"], $classement["nom"]);
    }
    return $listeClassements;
}

function affichageDuBoutonScoreboard(){
    /** Affiche le bouton scoreboard si il y a des classements
     *  @return void
     */
    $listeClassements = getClassements();
    if(!empty($listeClassements)) {
        echo "<a class='btn' href='/scoreboard.php'>Scoreboard</a>";
    }
}

function afficherClassements(){
    /** Affiche tous les classements
     *  @return void
     */
    $connexion_db = connect_db();
    $listeClassements = getClassements();
    // si il n'y a pas de classement on affiche un message
    if(empty($listeClassements)) {
        echo "<p>Il n'y a pas de classement pour le moment</p>";
    } else {
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
}

function getQuestions($idQuestionnaire){
    /** Retourne toutes les questions d'un questionnaire
     *  @return array(Question)
     */
    require_once("../classes/Question.php");
    $connexion_db = connect_db();

    $requete = $connexion_db->prepare("SELECT * FROM QUESTION WHERE idQuestionnaire = $idQuestionnaire");
    $requete->execute();
    $questions = $requete->fetchAll();

    $liste_de_questions = array();
    foreach($questions as $question){
        array_push($liste_de_questions, new Question($question['idQuestion'], $question['numero'], $question['question'], $question['typeQuestion'], $question['valeurQuestion'], $question['idQuestionnaire']));
    }
    return $liste_de_questions;
}

function getQuestion($idQuestion){
    /** Retourne une question
     *  @param $id Id d'une question
     *  @return Question
     */
    require_once("../classes/Question.php");
    $connexion_db = connect_db();

    $requete = $connexion_db->prepare("SELECT * FROM QUESTION WHERE idQuestion = $idQuestion");
    $requete->execute();
    $question = $requete->fetch();

    $question = new Question($question['idQuestion'], $question['numero'], $question['question'], $question['typeQuestion'], $question['valeurQuestion'], $question['idQuestionnaire']);
    return $question;
}

function getQuestionsOrdreNumero($idQuestionnaire){
    /** Retourne la liste des questions d'un questionnaire dans le sens des numéros
     *  @param $idQuestionnaire Id d'un questionnaire
     *  @return array(Question)
     */
    require_once("../classes/Question.php");
    $connexion_db = connect_db();

    $requete = $connexion_db->prepare("SELECT * FROM QUESTION WHERE idQuestionnaire = $idQuestionnaire ORDER BY numero");
    $requete->execute();
    $questions = $requete->fetchAll();

    foreach($questions as $question){
        $liste_de_questions[] = new Question($question['idQuestion'], $question['numero'], $question['question'], $question['typeQuestion'], $question['valeurQuestion'], $question['idQuestionnaire']);
    }
    return $liste_de_questions;
}

function getQuestionnaire($idQuestionnaire){
    /** Retourne un questionnaire
     *  @param $idQuestionnaire Id d'un questionnaire
     *  @return Questionnaire
     */
    $connexion_db = connect_db();
    $questionnaire = $connexion_db->prepare("SELECT * FROM QUESTIONNAIRE WHERE idQuestionnaire = $idQuestionnaire");
    $questionnaire->execute();
    $questionnaire = $questionnaire->fetch();
    return $questionnaire;
}

function getNombreDeQuestions($idQuestionnaire){
    /** Retourne le nombre de questions d'un questionnaire
     *  @param $idQuestionnaire Id d'un questionnaire
     *  @return int
     */
    $connexion_db = connect_db();
    $nombreDeQuestions = $connexion_db->prepare("SELECT COUNT(*) FROM QUESTION WHERE idQuestionnaire = $idQuestionnaire");
    $nombreDeQuestions->execute();
    $nombreDeQuestions = $nombreDeQuestions->fetch();
    return $nombreDeQuestions[0];
}

// function getReponseBonneQuestion($idQuestion){
//     $connexion_db = connect_db();
//     $reponseBonneQuestion = $connexion_db->prepare("SELECT reponse FROM REPONSE WHERE idQuestion = $idQuestion AND estBonne = 1");
//     $reponseBonneQuestion->execute();
//     $reponseBonneQuestion = $reponseBonneQuestion->fetch();
//     return $reponseBonneQuestion;
// }


function getIDMaxQuestion(){
    /** Retourne l'id max dans les Questions
     *  @return int
     */
    $connexion_db = connect_db();
    $idMaxQuestion = $connexion_db->prepare("SELECT MAX(idQuestion) FROM QUESTION");
    $idMaxQuestion->execute();
    $idMaxQuestion = $idMaxQuestion->fetch();
    return $idMaxQuestion[0];
}

function getNumeroMaxQuestion($idQ){
    /** Retourne le numéro max dans les Questions
     *  @param $idQ Id d'un questionnaire
     *  @return int
     */
    $connexion_db = connect_db();
    $numeroMaxQuestion = $connexion_db->prepare("SELECT MAX(numero) FROM QUESTION WHERE idQuestionnaire = $idQ");
    $numeroMaxQuestion->execute();
    $numeroMaxQuestion = $numeroMaxQuestion->fetch();
    return $numeroMaxQuestion[0];
}

function getIDMaxReponse(){
    /** Retourne l'id max dans les Réponses
     *  @return int
     */
    $connexion_db = connect_db();
    $idMaxReponse = $connexion_db->prepare("SELECT MAX(idReponse) FROM REPONSE");
    $idMaxReponse->execute();
    $idMaxReponse = $idMaxReponse->fetch();
    return $idMaxReponse[0];
}


function affichageQuestions($idQuestionnaire){
    /** Affiche les questions d'un questionnaire
     *  @param $idQuestionnaire Id d'un questionnaire
     *  @return void
     */
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
    /** Retourne les réponses d'une question
     *  @param $idQuestion Id d'une question
     *  @return array(Reponse)
     */
    $connexion_db = connect_db();
    $requete = $connexion_db->prepare("SELECT * FROM REPONSE WHERE idQuestion = $idQuestion");
    $requete->execute();
    $reponses = $requete->fetchAll();
    return $reponses;
}

function getReponsesListesQuestions($liste_de_questions) {
    /** Ajoute les réponses bonnes à chaque question
     *  @param $liste_de_questions Liste de questions
     *  @return array(Question)
     */
    require_once("../classes/Reponse.php");
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
    /** Retourne les réponses des utilisateurs
     *  @param $liste_de_questions Liste de questions
     *  @param $nombre_de_question Nombre de questions
     *  @return array(array(int))
     */
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
    /** Gère le résultat du questionnaire
     *  @param $idQuestionnaire Id d'un questionnaire
     *  @return void
     */
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
    /** Affichage des Résultats sur la page du même nom
     *  @param $nombre_de_question Nombre de questions
     *  @param $liste_questions Liste
     *  @param $reponse_utilisateur Réponses de l'utilisateur
     *  @param $score_utilisateur Score de l'utilisateur
     *  @param $score_max Score max
     */
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
    /** Permet de vérifier le résultat de l'utilisateur
     *  @param $type_question Type de question
     *  @param $reponse_utilisateur Réponse de l'utilisateur
     *  @param $question Question
     *  @param $score_utilisateur Score de l'utilisateur
     */
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

function affichageQuestionnaireListage() {
    /** Affiche des Questionnaire */
    $questionnaires = getQuestionnaires();

    foreach ($questionnaires as $questionnaire) {
        echo "<div id=".$questionnaire['idQuestionnaire']." class='ligneQuestion'>";
        echo "<h3>".$questionnaire['nom']."</h3>";
        echo "<a class='btn' href='/editQuestionnaire.php?id=".$questionnaire['idQuestionnaire']."'>Edit</a>";
        echo "<a class='btn' href='/deleteQuestionnaire.php?id=".$questionnaire['idQuestionnaire']."'>Delete</a>";
        echo "</div>";
    }
}

function affichageQuestionQuestionnaireListage(){
    /** Affiche les questions du questionnaire */
    // On récupère l'id du questionnaire
    $id = $_GET['id'];
            
    // On récupère le nom du questionnaire
    $questionnaire = getQuestionnaire($id);
    $nomQ = $questionnaire["nom"];
    echo "<h2>Liste des questions du questionnaire :<br></h2>";
    echo "<h3>".$nomQ."</h3>";
    
    // On récupère les questions du questionnaire
    $questions = getQuestions($id);

    // On affiche les questions dans un tableau avec un bouton pour modifier la question et un autre pour supprimer la question
    // si la liste des questions n'est pas vide
    if (!empty($questions)) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Question</th>";
        echo "<th>Type</th>";
        echo "<th>Valeur</th>";
        echo "<th>Modifier</th>";
        echo "<th>Supprimer</th>";
        echo "</tr>";
        foreach ($questions as $question) {
            echo "<tr>";
            echo "<td>".$question->getQuestion()."</td>";
            echo "<td>".$question->getTypeQuestion()."</td>";
            echo "<td>".$question->getValeurQuestion()."</td>";
            echo "<td><a href='/editQuestion.php?id=".$question->getId()."&idQ=".$id."'>Edit</a></td>";
            echo "<td><a href='deleteQuestion.php?id=".$question->getId()."&idQ=".$id."'>DELETE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h4>Il n'y a pas de questions dans ce questionnaire</h4>";
    }
}


function miseAJourDesNumerosQuestions($idQuestionnaire){
    // On récupère les questions du questionnaire
    $questions = getQuestionsOrdreNumero($idQuestionnaire);
    // On parcourt les questions
    for ($i = 0; $i < count($questions); $i++) {
        // On met à jour le numéro de la question
        updateNumeroQuestion($questions[$i]->getId(),$i+1);
    }
}

function updateNumeroQuestion($idQuestion,$numeroQuestion){
    // On récupère la connexion à la base de données
    $db = connect_db();
    // On prépare la requête
    $query = $db->prepare("UPDATE QUESTION SET numero = :numeroQuestion WHERE idQuestion = :idQuestion");
    // On exécute la requête
    $query->execute([
        "numeroQuestion" => $numeroQuestion,
        "idQuestion" => $idQuestion
    ]);
}

function allReponseFalsePourQuestion($id_question){
    // On récupère la connexion à la base de données
    $db = connect_db();
    // On prépare la requête
    $query = $db->prepare("UPDATE REPONSE SET estBonne = 0 WHERE idQuestion = :idQuestion");
    // On exécute la requête
    $query->execute([
        "idQuestion" => $id_question
    ]);
}

function updateQuestion($id_question, $nomQuestionP, $valeurP, $typeP, $reponses, $bonneReponse, $reponseQDeBase, $reponseP) {
    // echo "<pre>";
    // print_r($reponseQDeBase);
    // echo "</pre>";
    // On récupère la connexion à la base de données
    $db = connect_db();
    
    // On prépare la requête pour update la valeur de la question
    $query = $db->prepare("UPDATE QUESTION SET valeurQuestion = :valeur WHERE idQuestion = :idQuestion");
    // On exécute la requête
    $query->execute([
        "valeur" => $valeurP,
        "idQuestion" => $id_question
    ]);

    // On prépare la requête pour update le nom de la question
    $query = $db->prepare("UPDATE QUESTION SET QUESTION = :question WHERE idQuestion = :idQuestion");
    // On exécute la requête
    $query->execute([
        "question" => $nomQuestionP,
        "idQuestion" => $id_question
    ]);

    if ($typeP == "checkbox") {
        allReponseFalsePourQuestion($id_question);
        for ($i = 0; $i < count($reponses); $i++) {
            // On regarde si les bonne réponse a changé
            foreach ($bonneReponse as $reponse) {
                if ($reponse[0]-1 == $i) {
                    $idReponse = $reponseQDeBase[$i]["idReponse"];
                    // On prépare la requête pour update la bonne réponse
                    $query = $db->prepare("UPDATE REPONSE SET estBonne = 1 WHERE idReponse = :idReponse");
                    // On exécute la requête
                    $query->execute([
                        "idReponse" => $idReponse
                    ]);
                } 
            }
            // On regarde si le nom des réponses a changé
            if ($reponses[$i] != $reponseQDeBase[$i]["reponse"]) {
                // On prépare la requête pour update le nom de la réponse
                $query = $db->prepare("UPDATE REPONSE SET REPONSE = :reponse WHERE idReponse = :idReponse");
                // On exécute la requête
                $query->execute([
                    "reponse" => $reponses[$i],
                    "idReponse" => $reponseQDeBase[$i]["idReponse"]
                ]);
            }
        }
    } else if ($typeP == "radio") {
        allReponseFalsePourQuestion($id_question);
        
        // On récupère l'id de la bonne réponse
        foreach($reponseQDeBase as $reponse){
            if ($bonneReponse == $reponse["reponse"]) {
                $idReponse = $reponse["idReponse"];
            }
        }

        // On prépare la requête pour update la bonne réponse
        $query = $db->prepare("UPDATE REPONSE SET estBonne = 1 WHERE idReponse = :idReponse");
        // On exécute la requête
        $query->execute([
            "idReponse" => $idReponse
        ]);

        
        // On regarde si le nom des réponses a changé
        for ($i = 0; $i < count($reponses); $i++) {
            if ($reponses[$i] != $reponseQDeBase[$i]["reponse"]) {
                // On prépare la requête pour update le nom de la réponse
                $query = $db->prepare("UPDATE REPONSE SET REPONSE = :reponse WHERE idReponse = :idReponse");
                // On exécute la requête
                $query->execute([
                    "reponse" => $reponses[$i],
                    "idReponse" => $reponseQDeBase[$i]["idReponse"]
                ]);
            }
        }
    } else if ($typeP == "text" || $typeP == "number" || $typeP == "date") {
        // On modifie la réponse
        // On prépare la requête pour update le nom de la réponse
        $query = $db->prepare("UPDATE REPONSE SET REPONSE = :reponse WHERE idQuestion = :idQuestion");
        // On exécute la requête
        $query->execute([
            "reponse" => $reponseP,
            "idQuestion" => $id_question
        ]);
    }
}


function editQuestionDonnee(){
    // Récupération de l'id du questionnaire
    $idQ = $_GET['idQ'];
    echo "<input type='button' value='Retour' onclick='window.location.href=\"/editQuestionnaire.php?id=$idQ\"'>";
    
    // Récupération de l'id de la question
    $id = $_GET['id'];
    // Récupération de la question
    $question = getQuestion($id);
    // Récupération des réponses
    $reponseQ = getReponseQuestion($id);
    // Récupération du type de la question
    $type = $question->typeQuestion;

    echo "<h2>Modification de la question</h2>";
    echo "<form action='/editQuestion.php?id=$id&idQ=$idQ' method='post'>";

    // si il y a une requête POST
    if (isset($_POST['question'])) {
        // Récupération des données
        $nomQuestionP = $_POST['question'];
        $valeurP = $_POST['valeur'];
        $typeP = $type;
        $bonneReponse = array();
        $reponses = array();
        $reponseP = "";

        if ($typeP == "text") {
            $reponseP = $_POST['r1'];
        } else if ($typeP == "date") {
            $reponseP = $_POST['r1'];
        } else if ($typeP == "number") {
            $reponseP = $_POST['r1'];
        } else if ($typeP == "radio") {
            $nbDeReponse = count($_POST) - 3;
            for ($i = 1; $i <= $nbDeReponse; $i++) {
                $reponses[] = $_POST["r$i"];
            }
            $bonneReponse = $_POST['rep'];
        } else if ($typeP == "checkbox") {
            foreach ($_POST as $key => $value) {
                if (substr($key, 0, 1) == "i") {
                    // récupère le numéro après le i
                    $num = substr($key, 1);
                    $tuple = array($num, $value);
                    $bonneReponse[] = $tuple;
                } else if (substr($key, 0, 1) == "r") {
                    $reponses[] = $value;
                }
            }
        } 
        updateQuestion($id, $nomQuestionP, $valeurP, $typeP, $reponses, $bonneReponse, $reponseQ, $reponseP);
        // actualisation de la page
        echo "<script>window.location.href = '/editQuestion.php?id=$id&idQ=$idQ';</script>";
    }

    echo "<div id='conteneur'>";

    echo "<div id='gauche'>";
    echo "<p>Question : <input type='text' name='question' value=\"$question->question\" required><p>";
    echo "<p>Valeur : <input type='number' name='valeur' value=\"$question->valeurQuestion\" required><p>";
    echo "</div>";
    
    echo "<div id='droite'>";
    
    if ($type == "text") {
        $reponse = $reponseQ[0];
        $textR = $reponse["reponse"];
        echo "<p>Réponse : <input type='text' name='r1' value=\"$textR\" required><p>";
    } else if ($type == "radio") {
        $i = 1;
        foreach ($reponseQ as $reponse) {
            $textR = $reponse["reponse"];
            $bonne = $reponse["estBonne"];
            if ($bonne) {
                echo "<p>Réponse $i : <input type='radio' name='rep' id='r$i' value=\"$textR\" checked><input type='text' name='r$i' value=\"$textR\"><p>";
            } else {
                echo "<p>Réponse $i : <input type='radio' name='rep' id='r$i' value=\"$textR\"><input type='text' name='r$i' value=\"$textR\" ><p>";
            }
            $i++;
        }
    } else if ($type == "checkbox") {
        $i = 1;
        foreach ($reponseQ as $reponse) {
            $textR = $reponse["reponse"];
            $bonne = $reponse["estBonne"];
            if ($bonne) {
                echo "<p>Réponse $i : <input type='checkbox' name='i$i' value=\"$textR\" onclick=\"verifierCheckBoXButton()\" checked><input type='text' name='r$i' value=\"$textR\" required></p>";
            } else {
                echo "<p>Réponse $i : <input type='checkbox' name='i$i' value=\"$textR\" onclick=\"verifierCheckBoXButton()\"><input type='text' name='r$i' value=\"$textR\" required></p>";
            }
            $i++;
        }
    } else if ($type == "date") {
        $reponse = $reponseQ[0];
        $textR = $reponse["reponse"];
        echo "<p>Réponse : <input type='date' name='r1' value=\"$textR\" required><p>";
    } else if ($type == "number") {
        $reponse = $reponseQ[0];
        $textR = $reponse["reponse"];
        echo "<p>Réponse : <input type='number' name='r1' value=\"$textR\" required><p>";
    }

    echo "</div>";

    echo "</div>";
    echo "<input type='submit' value='Modifier'>";
    echo "</form>";
}


function addQuestion($idQ, $type) {
    // Formulaire pour créer la question
    echo "<form method='post' action='saveNewQuestion.php?id=$idQ'>";

    echo "<input type='hidden' name='type' value='$type'>";

    echo "<div id='conteneur'>";
    echo "<div id='gauche'>";
    echo "<label for='question'>Question</label>";
    echo "<input type='text' name='question' id='question' placeholder='Votre question....' required>";
    echo "<label for='type'>Valeur</label>";
    echo "<input type='number' name='valeur' id='valeur' min='0' placeholder='ex: 2'required>";
    echo "</div>";
    echo "<div id='droite'>";

    if ($type == "texte") {
        echo "<label for='reponse'>Réponse</label>";
        echo "<input type='text' name='reponse' id='reponse' required>";
    } else if ($type == "number") {
        echo "<label for='reponse'>Réponse</label>";
        echo "<input type='number' name='reponse' id='reponse' required>";
    } else if ($type == "date") {
        echo "<label for='reponse'>Réponse</label>";
        echo "<input type='date' name='reponse' id='reponse' required>";
    } else if ($type == "choix") {
        // Réponse 1 de base
        echo "<div id='1' class='reponseDiv'>";
        echo "<label for='reponse1'>Réponse 1</label>";
        echo "<input type='radio' name='reponse' id='r1' value='1' required>";
        echo "<input type='text' name='reponseTexte1' id='reponse1' placeholder='ici votre réponse...' required><br>";
        echo "</div>";
        
        // Réponse 2 de base
        echo "<div id='2' class='reponseDiv'>";
        echo "<label for='reponse'>Réponse 2</label>";
        echo "<input type='radio' name='reponse' id='r2' value='2' required>";
        echo "<input type='text' name='reponseTexte2' id='reponse2' placeholder='ici votre réponse...' required><br>";
        echo "</div>";

        // bouton pour ajouter une réponse
        echo "<input type='button' id='btnAdd' value='Ajouter une réponse' onclick='addReponse(\"$type\")'>";

        // bouton pour supprimer la réponse 
        echo "<input type='button' id='btnDel' value='Supprimer une réponse' onclick='delReponse(\"$type\")'>";
    } else if ($type == "choixMultiple") {
        // Réponse 1 de base
        echo "<div id='1' class='reponseDiv'>";
        echo "<label for='reponse1'>Réponse 1</label>";
        echo "<input type='checkbox' name='reponse1' id='r1' value='1' onclick='verifierCheckBoXButton()' checked>";
        echo "<input type='text' name='reponseTexte1' id='reponse1' placeholder='ici votre réponse...' required><br>";
        echo "</div>";
        
        // Réponse 2 de base
        echo "<div id='2' class='reponseDiv'>";
        echo "<label for='reponse'>Réponse 2</label>";
        echo "<input type='checkbox' name='reponse2' id='r2' value='2' onclick='verifierCheckBoXButton()'>";
        echo "<input type='text' name='reponseTexte2' id='reponse2' placeholder='ici votre réponse...' required><br>";
        echo "</div>";

        // bouton pour ajouter une réponse
        echo "<input type='button' id='btnAdd' value='Ajouter une réponse' onclick='addReponse(\"$type\")'>";

        // bouton pour supprimer la réponse 
        echo "<input type='button' id='btnDel' value='Supprimer une réponse' onclick='delReponse(\"$type\")'>";
    }

    echo "</div>";
    echo "</div>";

    
    echo "<input type='submit' value='Ajouter la question'>";
    echo "</form>";
}


function getMaxIDQuestionnaire(){
    $db = connect_db();
    $sql = "SELECT MAX(idQuestionnaire) FROM QUESTIONNAIRE";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $id = $stmt->fetch();
    return $id[0];
}

function verifierMdp($username){
    $db = connect_db();
    $sql = "SELECT mdp FROM UTILISATEUR WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $mdp = $stmt->fetch();
    return $mdp[0];
}

function verifierSiIlEstConnecte(){
    // Vérifie si l'utilisateur est connecté
    session_start();
    if (isset($_SESSION["username"])) {
        return true;
    } else {
        return false;
    }
}

function memeNomQuestionnaire($nomQuestionnaire) {
    $db = connect_db();
    $sql = "SELECT nom FROM QUESTIONNAIRE WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nomQuestionnaire]);
    $nom = $stmt->fetch();
    if ($nom) {
        return false;
    } else {
        return true;
    }
}

function creerQuestionnaire($nomQuestionnaire){
    $db = connect_db();
    $newId = getMaxIDQuestionnaire() + 1;
    $sql = "INSERT INTO QUESTIONNAIRE (idQuestionnaire, nom) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$newId, $nomQuestionnaire]);
}

function creerQuestion($question, $type, $valeur, $reponse, $idQuestionnaire) {
    $db = connect_db();

    // Création de la question
    $newId = getIDMaxQuestion() + 1;
    $numero = getNumeroMaxQuestion($idQuestionnaire) + 1;
    $sql = "INSERT INTO QUESTION (idQuestion, numero, question, typeQuestion, valeurQuestion, idQuestionnaire) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$newId, $numero, $question, $type, $valeur, $idQuestionnaire]);

    // Création des réponses

    // Si c'est un texte, un nombre ou une date
    if ($type == "number" || $type == "date") {
        $newIdR = getIDMaxReponse() + 1;
        $sql = "INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$newIdR, $reponse[0]["reponseTexte"], $reponse[0]["estBonne"], $newId]);
    } if ($type == "text") {
        $newIdR = getIDMaxReponse() + 1;
        $sql = "INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$newIdR, $reponse[0]["reponseTexte"], $reponse[0]["estBonne"], $newId]);
    } else if ($type == "radio") {
        for ($i=0; $i < count($reponse); $i++) { 
            $newIdR = getIDMaxReponse() + 1;
            $sql = "INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$newIdR, $reponse[$i]["reponseTexte"], $reponse[$i]["estBonne"], $newId]);
        }
    } else if ($type == "checkbox") {
        for ($i=0; $i < count($reponse); $i++) { 
            $newIdR = getIDMaxReponse() + 1;
            $sql = "INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$newIdR, $reponse[$i]["reponseTexte"], $reponse[$i]["estBonne"], $newId]);
        }
    }
}


function systemPourImport(){
    // Vérification que le formulaire a été soumis, du formulaire d'import
    if (isset($_POST['submitImport'])) {
        // Vérification que le fichier a bien été uploadé
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['name'] != "") {
            // Vérification que le fichier est bien un fichier JSON
            if (pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION) == 'json') {
                // Vérification que le fichier n'est pas vide
                if ($_FILES['fileToUpload']['size'] != 0) {
                    // Vérification que le fichier n'est pas trop gros
                    if ($_FILES['fileToUpload']['size'] < 1000000) {
                        // Lire le fichier JSON
                        $json = file_get_contents($_FILES['fileToUpload']['tmp_name']);
                        // Décoder le fichier JSON
                        $json_data = json_decode($json, true);
                        $nom_du_questionnaire = $json_data['nom'];
                        $questions = $json_data['questions'];
                        // Vérification que le questionnaire n'existe pas déjà
                        require_once('../functions/fonctions.php');
                        if (!memeNomQuestionnaire($nom_du_questionnaire)) {
                            creerQuestionnaire($nom_du_questionnaire);
                            $id_du_questionnaire_actuel = getMaxIDQuestionnaire();
                            foreach ($questions as $question) {
                                creerQuestion($question['question'], $question['type'], $question['valeur'],$question['reponses'], $id_du_questionnaire_actuel);
                            }
                        } else {
                            echo '<p class="error">Un questionnaire du même nom existe déja</p>';
                        }
                    } else {
                        echo '<p class="error">Le fichier est trop gros !</p>';
                    }
                }
            } 
        } else {
            echo '<p class="error">Le fichier n\'a pas été uploadé !</p>';
        }
    }
}