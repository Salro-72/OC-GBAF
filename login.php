<?php
session_start();
require 'configs/db.php';

if(isset($_POST['connexion'])){
    
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        die('Identifiant ou mot de passe invalide!');
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);
        
        //If $validPassword is TRUE, the login has been successful.
        if($validPassword){
            
            //Provide the user with a login session.
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
            <div class="title_box">
                <h1>Connectez-vous à votre espace membre:</h1>
            </div>
            <form action="login.php" method="post" class="option_box">

                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required><br>
            
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required><br>
            
                <input type="submit" name="connexion" value="Connexion">

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