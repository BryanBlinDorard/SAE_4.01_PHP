<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Quyz</title>
    </head>
    <style><?php include '../styles/home.css'; ?></style>
    <style><?php include '../styles/admin.css'; ?></style>
    
    <body>
        <?php
            require_once('../functions/fonctions.php');
            if (!verifierSiIlEstConnecte()) {
                header('Location: ./home.php');
            }
        ?>
        <header>
            <input type='button' value='Home' onclick='window.location.href="/home.php"'>
            <input type='button' value='Deconnexion' onclick='window.location.href="/logout.php"'>
        </header>
        <h2>Administration</h2>
        <div class="menu">
            <input type="button" value="Liste de questionnaires" onclick="window.location.href='/listes.php'">
            <input type="button" value="Créer un questionnaire" onclick="window.location.href='/addQuestionnaire.php'">
            <input type="button" value="I/E de questionnaires" onclick="window.location.href='/importExport.php'">
        </div>
    </body>
</html>