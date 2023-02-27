<?php
    require_once("../functions/fonctions.php");
    $db = connect_db();
    $nom = $_POST['name'];

    $newID = getMaxIDQuestionnaire() + 1;

    $sql = $db->prepare("INSERT INTO QUESTIONNAIRE (idQuestionnaire, nom) VALUES (:id, :nom)");
    $sql->bindParam(':id', $newID);
    $sql->bindParam(':nom', $nom);
    $sql->execute();

    header("Location: /editQuestionnaire.php?id=$newID");
?>