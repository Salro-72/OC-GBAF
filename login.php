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

    $req = $pdo->prepare('SELECT id_user, password FROM users WHERE pseudo = :pseudo');
    $req->execute(array(
        'pseudo' => $pseudo));
    $resultat = $req->fetch();
    
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
    
    if ($resultat)
    {
        if ($isPasswordCorrect) {
            $_SESSION['id_user'] = $resultat['id_user'];
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            header('Location: connected/homepage.php');
        }
        else
        {
            ?>
            <div class="msg_error">
                <p style="color:red; text-align:center;">Mauvais identifiant ou mot de passe !</p>
            </div>
            <?php
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
                <a href="index.php"><img src="GBAF_img/GBAF_logo.png" alt="Logo de GBAF" class="center"></a>
                <div class="title">
                    <h1>Connectez-vous à votre espace membre:</h1>
                </div>    
            </header>
            
            <form action="login.php" method="post" class="option_box">
                <label for="pseudo" class="names">Identifiant</label>
                    <input type="text" id="pseudo" name="pseudo" class="insert_box" required><br>
                <br>
                <label for="password" class="names">Mot de passe</label>
                    <input type="password" id="password" name="password" class="insert_box" required><br>
                <br>
                <input type="submit" name="login" value="Connexion" class="submit_button">

                <div class="box_link">
                    <p><a href="forgotpassword.php">Mot de passe oublié?</a></p>
                </div>  
                              
                <div class="box_link">
                    <p><a href="signup.php">Première visite?</a></p>
                </div> 
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>