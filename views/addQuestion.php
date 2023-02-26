<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        <?php
            require_once("../functions/fonctions.php");
            if (!verifierSiIlEstConnecte()) {
                header('Location: ./home.php');
            } 
        ?>

        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <style><?php include '../styles/edit.css'; ?></style>
        <script><?php include '../js/add.js'; ?></script>
        <script><?php include '../js/edit.js'; ?></script>

        <?php
            // On récupère l'id du questionnaire
            $idQ = $_GET['id'];
            
            // Bouton retour
            echo "<input type='button' value='Retour' onclick='window.location.href=\"/editQuestionnaire.php?id=$idQ\"'>";
            
            $type = $_POST['type'];
            echo "<h2>Création de la question</h2>";
            
            addQuestion($idQ, $type);
        ?>
    </body>
</html>