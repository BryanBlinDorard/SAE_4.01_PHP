<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <header>
            <input type="button" value="Login" onclick="window.location.href='/login.php'">
        </header>
        <div class="container">
            <div id="home" class="h-center h-column">
                <h1>Quyz</h1>
                <a class="btn" href="/menu.php">Play</a>
                <?php
                    require_once("../functions/fonctions.php");
                    affichageDuBoutonScoreboard();
                ?>
            </div>
        </div>
        
    </body>
</html>