<?php
session_start();
require 'configs/db.php';

if(isset($_POST['envoyer'])){

    $pseudo = !empty($_POST['pseudo']) ? trim($_POST['pseudo']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $answer = !empty($_POST['answer']) ? trim($_POST['answer']) : null;

    $sql = "SELECT COUNT(pseudo) AS num FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':pseudo', $pseudo);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['num'] > 0){
        die('Cet identifiant est déjà pris!<br> <a href="signup.php">Veuillez bien réessayez (cliquez ici)</a>');
    }
    
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    
    $sql = "INSERT INTO users (pseudo, password, firstname, lastname, question, answer)
            VALUES (:pseudo, :password, :firstname, :lastname, :question, :answer)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':answer', $answer);

    $result = $stmt->execute();
    
    if($result){
        header("location: login.php");
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
                <h1>Nouveau chez nous?</h1>
            </div>
        </header>        
            <div class="title_box">
                <h2>Veuillez remplir tous les sections demandés:</h2>
            </div>   
            
            <form action="signup.php" method="post" class="option_box">
                <label for="lastname" class="names">Nom</label>
                    <input type="text" id="lastname" name="lastname" class="insert_box"  required><br>
                <br>
                <label for="firstname" class="names">Prénom</label>
                    <input type="text" id="firstname" name="firstname" class="insert_box" required><br>
                <br>
                <label for="pseudo" class="names">Identifiant</label>
                    <input type="text" id="pseudo" name="pseudo" class="insert_box" required><br>
                <br>
                <label for="password" class="names">Mot de passe</label>
                    <input type="password" id="password" name="password" required><br>
                <br>
                <label for="question" class="names">Votre question sécrete</label>
                    <textarea id="question" name="question" cols="30" rows="3" 
                    placeholder="Par exemple 'Le nom de mon premier prof de maths?'" class="insert_box" required></textarea>
                <br>
                <label for="answer" class="names">Votre rèponse sécrete</label>
                    <input type="password" id="answer" name="answer" class="insert_box" required><br>
                <br>
                
                <input type="submit" name="envoyer" value="Envoyer" class="submit_button"></input>
                
                <form action="signup.php" method="post" class="box_link">
                        <p>Déjà un compte? <a href="login.php">Connexion</a>
                </form>
            </form>
            <?php include("php/footer.php"); ?>
    </body>
</html>