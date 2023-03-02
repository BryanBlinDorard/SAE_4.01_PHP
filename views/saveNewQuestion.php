<?php
    require_once("../functions/fonctions.php");
    $db = connect_db();


    // Je récupère tous les $_POST
    $liste = $_POST;
    // Je récupère l'id du questionnaire
    $idQ = $_GET['id'];
    // Je récupère le type de la question
    $type = $_POST['type'];
    // Je récupère la question
    $question = $_POST['question'];
    // Je récupère la valeur
    $valeur = $_POST['valeur'];
    
    // On ajoute la question dans la base de données
    $newID = getIDMaxQuestion() + 1;
    $newNumero = getNumeroMaxQuestion($idQ) + 1;

    // si c'est un choix, je récupère les réponses
    if ($type == "choix") {
        $bonneReponse = null;
        $reponses = array();
        $i = 1;
        while (isset($_POST["reponseTexte$i"])) {
            $reponses[] = $_POST["reponseTexte$i"];
            $i++;
        }
        $indiceBonneReponse = $_POST['reponse'];
        $bonneReponse = $reponses[$indiceBonneReponse - 1];

        // On ajoute la question dans la base de données
        $sql = $db->prepare("INSERT INTO QUESTION (idQuestion, numero, question, typeQuestion, valeurQuestion, idQuestionnaire) VALUES ($newID, $newNumero, '$question', 'radio', $valeur, $idQ)");
        $sql->execute();
    
        // On ajoute les réponses dans la base de données
        foreach ($reponses as $reponse) {
            $newIDReponse = getIDMaxReponse() + 1;
            if ($reponse == $bonneReponse) {
                $sql2 = $db->prepare("INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES ($newIDReponse, '$reponse', 1, $newID)");
                $sql2->execute();
            } else {
                $sql2 = $db->prepare("INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES ($newIDReponse, '$reponse', 0, $newID)");
                $sql2->execute();
            }
        }
    } else if ($type == "texte" || $type == "number" || $type == "date") {
        
        if ($type == "texte") {
            $type = "text";
        } else if ($type == "number") {
            $type = "number";
        } else if ($type == "date") {
            $type = "date";
        }

        // On ajoute la question dans la base de données
        $sql = $db->prepare("INSERT INTO QUESTION (idQuestion, numero, question, typeQuestion, valeurQuestion, idQuestionnaire) VALUES ($newID, $newNumero, '$question', '$type', $valeur, $idQ)");
        $sql->execute();
        
        // On ajoute la réponse dans la base de données
        $newIDReponse = getIDMaxReponse() + 1;
        $reponse = $_POST['reponse'];
        $sql2 = $db->prepare("INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES ($newIDReponse, '$reponse', 1, $newID)");
        $sql2->execute();
    } else if ($type == "choixMultiple") {
        $type = "checkbox";

        // On ajoute la question dans la base de données
        $sql = $db->prepare("INSERT INTO QUESTION (idQuestion, numero, question, typeQuestion, valeurQuestion, idQuestionnaire) VALUES ($newID, $newNumero, '$question', '$type', $valeur, $idQ)");
        $sql->execute();

        // On ajoute les réponses dans la base de données
        $bonneReponseID = array();
        $bonneReponse = array();
        $reponses = array();
        $i = 1;
        while (isset($_POST["reponseTexte$i"])) {
            $reponses[] = $_POST["reponseTexte$i"];
            $i++;
        }

        foreach ($liste as $key => $value) {
            // si la longueur de la clé est supérieure à 7 
            if (substr($key, 0, 7) == "reponse" && strlen($key) == 8) {
                $bonneReponseID[] = $value;
            }
        }

        // pour chaque id de bonne réponse, on récupère la réponse correspondante
        foreach ($bonneReponseID as $id) {
            $bonneReponse[] = $_POST["reponseTexte$id"];
        }

        // On ajoute les réponses dans la base de données
        foreach ($reponses as $reponse) {
            $newIDReponse = getIDMaxReponse() + 1;
            if (in_array($reponse, $bonneReponse)) {
                $sql2 = $db->prepare("INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES ($newIDReponse, '$reponse', 1, $newID)");
                $sql2->execute();
            } else {
                $sql2 = $db->prepare("INSERT INTO REPONSE (idReponse, reponse, estBonne, idQuestion) VALUES ($newIDReponse, '$reponse', 0, $newID)");
                $sql2->execute();
            }
        }
    }

    // redirige vers la page editQuestionnaire.php
    header("Location: /editQuestionnaire.php?id=$idQ");
?>