<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/game.css'; ?></style>
        <input type="button" value="Menu questionnaire" onclick="window.location.href='/menu.php'">
        <div class="game">
            <h2>Questionnaire 1</h2>
            <div id="q1" class="question">
                <h3>Question 1</h3>
                <div class="textAnswer">
                    <input type="text" name="answer" placeholder="Votre réponse">
                </div>
            </div>
            <div id="q2" class="question">
                <h3>Question 2</h3>
                <div class="checkboxAnswer">
                    <input type="checkbox" name="answer" value="1">
                    <label for="answer">Réponse 1</label><br>
                    <input type="checkbox" name="answer" value="2">
                    <label for="answer">Réponse 2</label><br>
                    <input type="checkbox" name="answer" value="3">
                    <label for="answer">Réponse 3</label><br>
                    <input type="checkbox" name="answer" value="4">
                    <label for="answer">Réponse 4</label><br>
                </div>
            </div>
            <div id="q3" class="question">
                <h3>Question 3</h3>
                <div class="radioAnswer">
                    <input type="radio" name="answer" value="1"> Réponse 1<br>
                    <input type="radio" name="answer" value="2"> Réponse 2<br>
                    <input type="radio" name="answer" value="3"> Réponse 3<br>
                    <input type="radio" name="answer" value="4"> Réponse 4<br>
                </div>
            </div>
            <div id="q4" class="question">
                <h3>Question 4</h3>
                <div class="selectAnswer">
                    <select name="answer">
                        <option value="1">Réponse 1</option>
                        <option value="2">Réponse 2</option>
                        <option value="3">Réponse 3</option>
                        <option value="4">Réponse 4</option>
                    </select>
                </div>
            </div>
            <div id="q5" class="question">
                <h3>Question 5</h3>
                <div class="colorAnswer">
                    <input type="color" name="answer">
                </div>
            </div>

            <div id="q6" class="question">
                <h3>Question 6</h3>
                <div class="dateAnswer">
                    <input type="date" name="answer">
                </div>
            </div>

            <div id="q7" class="question">
                <h3>Question 7</h3>
                <div class="numberAnswer">
                    <input type="number" name="answer">
                </div>
            </div>

            <form action="/resultat.php" method="post">
                <input type="submit" value="Valider">
            </form>
    </body>
</html>