<?php 
    require_once("connect.php");

    $dsn = "mysql:dbname=".BASE.";host=".SERVER;
    try {
        $connexion = new PDO($dsn, USER, PASSWORD);
    } catch(PDOException $e) {
        printf("Échec de la connexion : %s\n"; $e->getMessage());
        exit();
    }
?>