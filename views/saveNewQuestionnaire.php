<?php
    require_once("../functions/fonctions.php");
    $db = connect_db();
    $nom = $_POST['name'];

    $newID = getMaxIDQuestionnaire() + 1;

    if (memeNomQuestionnaire($nom_du_questionnaire)) {
        $sql = $db->prepare("INSERT INTO QUESTIONNAIRE (idQuestionnaire, nom) VALUES (:id, :nom)");
        $sql->bindParam(':id', $newID);
        $sql->bindParam(':nom', $nom);
        $sql->execute();
        header("Location: /editQuestionnaire.php?id=$newID");
    } else {
        header("Location: /addQuestionnaire.php?error=1");
    }

?>