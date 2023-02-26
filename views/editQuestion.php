<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <style><?php include '../styles/edit.css'; ?></style>
        <script><?php include '../js/edit.js'; ?></script>
        
        <?php
            require_once("../functions/fonctions.php");
            editQuestionDonnee();
        ?>
    </body>
</html>