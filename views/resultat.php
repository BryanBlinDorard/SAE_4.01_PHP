<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/resultat.css'; ?></style>
        <div class="fenetreResultat">
            <div class="resultat">
                <h1>Résultats</h1>
                <?php 
                    require("../functions/fonctions.php");
                    
                    $idQuestionnaire = $_POST['questionnaire'];
                    $score_utilisateur = gererResultat($idQuestionnaire);
                    print_r($score_utilisateur);
                ?>
                <button onclick="window.location.href = 'menu.php';">Retour sur la page des questionnaires</button>
            </div>
            <aside id="asideDroite">
                <form method="post" action="save.php">
                    <h3>Sauvegarder</h3>
                    <p>Voulez-vous enregistrer votre score ?</p>
                    <input type="hidden" name="score" value="<?php echo $score_utilisateur; ?>">
                    <input type="hidden" name="idQuestionnaire" value="<?php echo $idQuestionnaire; ?>">
                    <input type="text" name="nom" placeholder="Votre nom" required pattern="[a-zA-Z]{3,}">
                    <input type="submit" name="save" value="Cliquer ici">
                </form>
                <?php 
                    if (isset($_POST['save'])){
                        echo "<p>Votre score a bien été enregistré !</p>";
                    }
                ?>
            </aside>
        </div>
    </body>
</html>