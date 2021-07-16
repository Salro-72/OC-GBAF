<?php
session_start();
require 'configs/db.php';

if(isset($_POST['connexion'])){
    

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
 
    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':username', $username);
    
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user === false){
        die('Incorrect username / password combination!');
    } else{
        $validPassword = password_verify($passwordAttempt, $user['password']);
        
        if($validPassword){
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            
            header('Location: homepage.php');
            exit;
            
        } else{
            die('Incorrect username / password combination!');
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
                <?php include("php/logo.php"); ?>
            </header>
        <body>
        <div class="title">
                <h1>Votre compte a bien été crée!</h1>
            </div>
                
            <div class="title">
                <h2>Connectez-vous à votre espace membre</h2>
            </div> 
            <form action="login.php" method="post" class="option_box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"><br>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password"><br>
                
                <input type="submit" name="connexion" value="Connexion">
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>
