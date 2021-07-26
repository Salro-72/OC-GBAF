<?php
session_start();
require 'configs/db.php';

if(isset($_POST['envoyer'])){

    $pseudo = !empty($_POST['pseudo']) ? trim($_POST['pseudo']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $reponse = !empty($_POST['reponse']) ? trim($_POST['reponse']) : null;
    
    //TO ADD: Error checking (pseudo characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.

    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(pseudo) AS num FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided pseudo to our prepared statement.
    $stmt->bindValue(':pseudo', $pseudo);
    
    //Execute.
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['num'] > 0){
        die('Cet identifiant est déjà pris!');
    }
    
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "INSERT INTO users (pseudo, password, firstname, lastname, question, reponse)
            VALUES (:pseudo, :password, :firstname, :lastname, :question, :reponse)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':reponse', $reponse);

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
            <img src="GBAF_img/GBAF_logo.png" alt="Logo de GBAF" class="center"/>
            <div class="title">
                <h1>Nouveau chez nous?</h1>
            </div>
            </header>
                
            <div class="title_box">
                <h2>Veuillez remplir tous les sections demandés:</h2>
            </div>   
            
            <form action="signup.php" method="post" class="option_box">
            
                <label for="pseudo" class="names">Identifiant</label>
                <input type="text" id="pseudo" name="pseudo" required><br>
                <br>
                <label for="password" class="names">Mot de passe</label>
                <input type="password" id="password" name="password" required><br>
                <br>
                <label for="firstname" class="names">Prénom</label>
                <input type="text" id="firstname" name="firstname" required><br>
                <br>
                <label for="lastname" class="names">Nom</label>
                <input type="text" id="lastname" name="lastname" required><br>
                <br>
                <label for="question" class="names">Votre question sécrete</label>
                <textarea id="question" name="question" cols="30" rows="3" 
                placeholder="Par exemple 'Le nom de mon premier prof de maths?'" required></textarea>
                <br>
                <label for="reponse" class="names">Votre rèponse sécrete</label>
                <input type="text" id="reponse" name="reponse" required><br>
                <br>
                <input type="submit" name="envoyer" value="Envoyer" class="connexion_button"></input>
                
                <form action="signup.php" method="post">
                        <p>Déjà un compte? <a href="login.php">Connexion</a>
                </form>
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>