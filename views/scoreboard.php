<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/scoreboard.css'; ?></style>
        <input type="button" value="Accueil" onclick="window.location.href='/home.php'">
        <h1>Voici les Scores</h1>
        <div class="scoreboard">
            <?php
                require_once("../connexion.php");
                require_once("../classes/Classement.php");
                $requete = $connexion->prepare("select * from QUESTIONNAIRE natural join CLASSEMENT");
                $requete->execute();
                $classements = $requete->fetchAll();

                foreach($classements as $classement) {
                    $listeClassements[] = new Classement($classement["idClassement"], $classement["idQuestionnaire"], $classement["nom"]);
                }
                foreach($listeClassements as $classement) {
                    echo "<div id=\"Q".$classement->id."\" class=\"questionnaireScoreboard\">";
                    echo "<h3>".$classement->nomQuestionnaire."</h3>";
                    echo "<table class=\"tableau\"";
                    echo "<tr>";
                    echo "<th>Score</th>";
                    echo "<th>Nom</th>";
                    echo "</tr>";
                    $requeteScore = $connexion->prepare("select * from SCORE natural join CLASSEMENT where idClassement=".$classement->id." order by scorePersonne desc");
                    $requeteScore->execute();
                    $scores = $requeteScore->fetchAll();
                    foreach($scores as $score) {
                        echo "<tr>";
                        echo "<td>".$score["scorePersonne"]."</td>";
                        echo "<td>".$score["nomPersonne"]."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
            ?>        
    </body>
</html>