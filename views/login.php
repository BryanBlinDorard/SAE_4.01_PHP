<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quyz</title>
    </head>
    
    <body>
        <style><?php include '../styles/home.css'; ?></style>
        <style><?php include '../styles/login.css'; ?></style>
        <h1>Connexion</h1>
        

        
        <?php 
            require_once('../functions/fonctions.php');
            if (verifierSiIlEstConnecte()) {
                header('Location: ./admin.php');
            } else {

                // si il y a une requête POST (formulaire envoyé)
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $db = connect_db();

                    // on récupère les données du formulaire
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    
                    // on vérifie que les champs ne sont pas vides
                    if (!empty($username) && !empty($password)) {
                        // on vérifie que l'utilisateur existe
                        $user = $db->query("SELECT * FROM UTILISATEUR WHERE nom = '$username'")->fetch();
                        if ($user) {
                            // on vérifie que le mot de passe est correct
                            if (verifierMdp($username) == $password) {
                                $_SESSION['username'] = $username;
                                // on redirige vers la page d'accueil
                                header('Location: ./admin.php');
                            } else {
                                // on affiche un message d'erreur en rouge avec un span
                                echo "<center><span style='color:crimson'>Nom d'utilisateur ou mot de passe incorrect</span></center>";
                            }
                            
                        } else {
                            // on affiche un message d'erreur en rouge avec un span
                            echo "<center><span style='color:crimson'>Nom d'utilisateur ou mot de passe incorrect</span></center>";
                        }
                    }
                }

                
                echo "<div class='login'>";
                echo "<form action='login.php' method='post'>";
                echo "<label for='username'>Nom d'utilisateur </label>";
                echo "<input type='text' name='username' id='username' placeholder=\"Nom d'utilisateur\" required>";
                echo "<br>";
                echo "<label for='password'>Mot de passe </label>";
                echo "<input type='password' name='password' id='password' placeholder='Mot de passe' required>";
                echo "<input type='submit' value='Se connecter'>";
                echo "</form>";
                echo "</div>";
            }
        ?>
    </body>
</html>