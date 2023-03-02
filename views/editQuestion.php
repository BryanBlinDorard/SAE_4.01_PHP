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
        <script><?php include '../js/edit.js'; ?></script>
        
        <?php
            editQuestionDonnee();
        ?>
    </body>
</html>