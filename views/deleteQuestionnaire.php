<?php
    require_once('../functions/fonctions.php');
    if (!verifierSiIlEstConnecte()) {
        header('Location: ./home.php');
    } else {
        // récupération de l'id de la question en GET
        $id = $_GET['id'];
        
        // connexion à la base de données
        require_once("../functions/fonctions.php");
        $db = connect_db();


        
        // récupération de l'id du classement du questionnaire
        $requeteClassement = "SELECT idClassement FROM CLASSEMENT WHERE idQuestionnaire = $id";
        $resultatClassement = $db->query($requeteClassement);
        $idClassement = $resultatClassement->fetch();
        $idClassement = $idClassement['idClassement'];
        
        // regarde si il y a un classement sur le questionnaire
        if ($idClassement != null) {
            // supprime tout les scores du classement 
            $requeteScore = "DELETE FROM SCORE WHERE idClassement = $idClassement";
            $resultatScore = $db->query($requeteScore);

            // supprime le classement
            $requeteClassement = "DELETE FROM CLASSEMENT WHERE idClassement = $idClassement";
            $classement = $db->query($requeteClassement);
        }


        // supprime les réponses
        $requeteReponses = "DELETE FROM REPONSE WHERE idQuestion IN (SELECT idQuestion FROM QUESTION WHERE idQuestionnaire = $id)";
        $reponse = $db->query($requeteReponses);

        // supprime les questions
        $requeteQuestions = "DELETE FROM QUESTION WHERE idQuestionnaire = $id";
        $question = $db->query($requeteQuestions);

        // supprime le questionnaire
        $requeteQuestionnaire = "DELETE FROM QUESTIONNAIRE WHERE idQuestionnaire = $id";
        $questionnaire = $db->query($requeteQuestionnaire);

        // redirection vers la page de listage des questionnaires
        header("Location: listes.php");
    }
?>