<?php
    require_once("../functions/fonctions.php");
    if (!verifierSiIlEstConnecte()) {
        header('Location: ./home.php');
    } else {

        // récupération de l'id de la question en GET
        $id = $_GET['id'];
        $idQ = $_GET['idQ'];
        
        // connexion à la base de données
        require_once("../functions/fonctions.php");
        $db = connect_db();

        // suppression des réponses de la question
        $reponse = "DELETE FROM REPONSE WHERE idQuestion = $id";
        // exécution de la requête
        $db->query($reponse);

        // suppression de la question
        $question = "DELETE FROM QUESTION WHERE idQuestion = $id";
        // exécution de la requête
        $db->query($question);
        
        $questions = getQuestions($idQ);
        if (count($questions) != 0) {
            // On actualise les numéros des questions
            miseAJourDesNumerosQuestions($idQ);
        }

        

        // redirection vers la page de listage des questionnaires
        header("Location: editQuestionnaire.php?id=$idQ");
    }
?>