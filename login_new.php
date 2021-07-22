<?php
session_start();
require 'configs/db.php';

if(isset($_POST['login'])){
    
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':username', $username);
    //Execute.
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //  Récupération de l'utilisateur et de son pass hashé
    $req = $pdo->prepare('SELECT id_user, password FROM users WHERE username = :username');
    $req->execute(array(
        'username' => $username));
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
                $_SESSION['username'] = $username;
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
        <h1 class="title_succes">Votre compte a bien été crée !</h1>
            <div class="title_box">
                <h1>Connectez-vous à votre espace membre:</h1>
            </div>
            <form action="login.php" method="post" class="option_box">

                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required><br>
            
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required><br>
            
                <input type="submit" name="login" value="Connexion">
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>