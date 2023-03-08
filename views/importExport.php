<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Quyz</title>
    </head>
    

    <body>
        <header><a href="admin.php"><button>Retour</button></a></header>
        <h2>Importer et exporter des questionnaires</h2>

        <?php 
            require_once('../functions/fonctions.php');
            systemPourImport();
        ?>


        <div class="importExport">
            <div class = "import">
                <h3>Importer un questionnaire</h3>
                <form action="importExport.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <br>
                    <input type="submit" value="Importer" name="submitImport">
                </form>
            </div>
            <div class = "export">
                <h3>Exporter un questionnaire</h3>
                <form action="export.php" method="post">
                    <select name="questionnaire">
                        <?php 
                            require_once('../functions/fonctions.php');
                            $questionnaires = getQuestionnaires();
                            foreach ($questionnaires as $questionnaire) { ?>
                            <option value="<?php echo $questionnaire['idQuestionnaire']; ?>"><?php echo $questionnaire['nom']; ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <input type="submit" value="Exporter" name="submitExport">
                </form>
                <i>Seulement sur linux</i>
            </div>
        </div>

        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/admin.css'; ?></style>
        <style><?php include '../styles/IE.css'; ?></style>
    </body>
</html>