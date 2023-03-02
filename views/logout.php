<?php
    // démarre la session
    session_start();
    session_unset();
    session_destroy();
    // redirige vers la page d'accueil
    header('Location: ./home.php');
?>