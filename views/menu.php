<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/menu.css'; ?></style>
        <h2>Choisissez un questionnaire</h2>
        <div class="menu">
            <div id="Q1" class="questionnaire">
                <h3>Questionnaire 1</h3>
                <form action="/game.php" method="post">
                    <input type="hidden" name="questionnaire" value="1">
                    <input type="submit" value="Jouer">
                </form>
            </div>
            <div id="Q2" class="questionnaire">
                <h3>Questionnaire 2</h3>
                <form action="/game.php" method="post">
                    <input type="hidden" name="questionnaire" value="2">
                    <input type="submit" value="Jouer">
                </form>
            </div>
            <div id="Q3" class="questionnaire">
                <h3>Questionnaire 3</h3>
                <form action="/game.php" method="post">
                    <input type="hidden" name="questionnaire" value="3">
                    <input type="submit" value="Jouer">
                </form>
            </div>
            <div id="Q4" class="questionnaire">
                <h3>Questionnaire 4</h3>
                <form action="/game.php" method="post">
                    <input type="hidden" name="questionnaire" value="4">
                    <input type="submit" value="Jouer">
                </form>
            </div>
            <div id="Q5" class="questionnaire">
                <h3>Questionnaire 5</h3>
                <form action="/game.php" method="post">
                    <input type="hidden" name="questionnaire" value="5">
                    <input type="submit" value="Jouer">
                </form>
            </div>
        </div>
        
    </body>
</html>