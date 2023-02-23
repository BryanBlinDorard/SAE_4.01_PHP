<?php 
// Récupération de la connexion à la base de données
require_once("../functions/fonctions.php");
$connexion = connect_db();

// récupération des données du formulaire
$nom = $_POST['nom'];
$nom = "'$nom'";
$score = $_POST['score'];
$id_questionnaire = $_POST['idQuestionnaire'];

// Récupération de l'id du classement par rapport à l'id du questionnaire
$id_classement = $connexion->prepare("SELECT idClassement FROM CLASSEMENT WHERE idQuestionnaire = $id_questionnaire");
$id_classement->execute();
$id_classement = $id_classement->fetch();
$id_classement = $id_classement['idClassement'];

// Si le classement n'existe pas, on le crée
if ($id_classement == null){
    // Récupération de l'id max de la table CLASSEMENT
    $id_classement = $connexion->prepare("SELECT MAX(idClassement) FROM CLASSEMENT");
    $id_classement->execute();
    $id_classement = $id_classement->fetch();
    $id_classement = $id_classement['MAX(idClassement)'];
    $id_classement++;

    // Insertion du classement dans la table CLASSEMENT
    $insertion_classement = $connexion->prepare("INSERT INTO CLASSEMENT VALUES ($id_classement, $id_questionnaire)");
    $insertion_classement->execute();
}


// Récupération de l'id max de la table SCORE
$id_score = $connexion->prepare("SELECT MAX(idScore) FROM SCORE");
$id_score->execute();
$id_score = $id_score->fetch();
$id_score = $id_score['MAX(idScore)'];
$id_score++;

// Insertion du score dans la table SCORE
$insertion_score = $connexion->prepare("INSERT INTO SCORE VALUES ($id_score, $score, $nom,$id_classement)");
$insertion_score->execute();

// redirection vers la page de classement
if (isset($_POST['nom'])){
    header('Location: home.php');
}
?>