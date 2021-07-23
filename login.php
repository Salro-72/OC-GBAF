<?php
session_start();
require 'configs/db.php';

if(isset($_POST['login'])){
    
    $pseudo = !empty($_POST['pseudo']) ? trim($_POST['pseudo']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;

    $sql = "SELECT COUNT(pseudo) AS num FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //  Récupération de l'utilisateur et de son mot de passe hashé
    $req = $pdo->prepare('SELECT id_user, password FROM users WHERE pseudo = :pseudo');
    $req->execute(array(
        'pseudo' => $pseudo));
    $resultat = $req->fetch();
    
    // Comparaison du pass envoyé via le formulaire avec la base
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
    
    if (!$resultat)
    {
        echo 'Mauvais identifiant ou mot de passe !';
    }
        else
        {
            if ($isPasswordCorrect) {
                $_SESSION['id_user'] = $resultat['id_user'];
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                header('Location: connected/homepage.php');
                exit;
        }
        else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="style_GBAF.css"/>
        <title>Extranet GBAF</title>
    </head>    
        <body>
            <header>
            <img src="GBAF_img/GBAF_logo.png" alt="Logo de GBAF" class="center"/>
            </header>
        <body>
            <div class="title_box">
                <h1>Connectez-vous à votre espace membre:</h1>
            </div>
            <form action="login.php" method="post" class="option_box">

                <label for="pseudo">Identifiant</label>
                <input type="text" id="pseudo" name="pseudo" required><br>
                <br>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required><br>
                <br>
                <input type="submit" name="login" value="Connexion">

                <div class="new_password">
                    <p><a href="forgotpassword.php">Mot de passe oublié?</a></p>
                </div>  
                              
                <div class="new_inscription">
                    <p><a href="signup.php">Première visite?</a></p>
                </div> 
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>