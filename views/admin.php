<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Quyz</title>
    </head>
    <script><?php include '../js/game.js'; ?></script>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/admin.css'; ?></style>
        <input type='button' value='Home' onclick='window.location.href="/home.php"'>
        <h2>Administration</h2>
        <div class="menu">
            <input type="button" value="Liste de questionnaires" onclick="window.location.href='/listes.php'">
            <input type="button" value="Créer un questionnaire" onclick="window.location.href='/addQuestionnaire.php'">
            <input type="button" value="I/E de questionnaires" onclick="window.location.href='/IEQuestionnaire.php'">
        </div>
    </body>
</html>