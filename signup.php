<?php
session_start();
require 'configs/db.php';

if(isset($_POST['envoyer'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $reponse = !empty($_POST['reponse']) ? trim($_POST['reponse']) : null;
    
    //TO ADD: Error checking (username characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.

    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['num'] > 0){
        die('Cet identifiant est déjà pris!');
    }
    
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "INSERT INTO users (username, password, firstname, lastname, question, reponse)
            VALUES (:username, :password, :firstname, :lastname, :question, :reponse)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':reponse', $passwordHash);

    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        header("location: login_new.php");
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
            
            <div class="title">
                <h1>Nouveau chez nous?</h1>
            </div>
                
            <div class="title_box">
                <h2>Veuillez remplir tous les sections demandés:</h2>
            </div>   
            
            <form action="signup.php" method="post" class="option_box">
            
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required><br>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required><br>

                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" required><br>

                <label for="lastname">Nom</label>
                <input type="text" id="firtsname" name="lastname" required><br>

                <label for="question">Votre question sécrete</label>
                <input type="text" id="question" name="question"required><br>

                <label for="reponse">Votre rèponse sécrete</label>
                <input type="password" id="reponse" name="reponse" required><br>

                <input type="submit" name="envoyer" value="Envoyer"></button>
                
                <form action="signup.php" method="post">
                        <p>Déjà un compte? <a href="login.php">Connexion</a>
                </form>
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>