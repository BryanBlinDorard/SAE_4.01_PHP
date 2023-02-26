<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    <header>
        <input type="button" value="Login" onclick="window.location.href='/admin.php'">
    </header>
    <body>
        <style><?php include '../styles/home.css'; ?></style>
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