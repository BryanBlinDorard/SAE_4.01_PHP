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
        <script><?php include '../js/modal.js'; ?></script>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <style><?php include '../styles/edit.css'; ?></style>
        <?php
            $idQ = $_GET['id'];
            echo "<header>";
            echo "<input type='button' value='Retour' onclick='window.location.href=\"/listes.php\"'>";
            // un bouton qui affiche une fenêtre modale
            echo "<input type='button' value='Ajouter une question' onclick='openModal()'>";
            echo "</header>";
            
            affichageQuestionQuestionnaireListage()
            ?>

        <!-- La boîte de dialogue modale -->
        <div id="myModal" class="modal">
            <!-- Le contenu de la boîte de dialogue modale -->
            <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <!-- Demander le type de la question a créer-->
            <form method="post" action="addQuestion.php?id=<?php echo $idQ; ?>">
                <label for="type">Type de la question</label>
                <select name="type" id="type">
                    <option value="texte">Texte</option>
                    <option value="number">Nombre</option>
                    <option value="date">Date</option>
                    <option value="choix">Choix</option>
                    <option value="choixMultiple">Choix multiple</option>
                </select>
                <br>
                <input type="submit" value="Créer">
            
        </div>
        
    </body>
</html>