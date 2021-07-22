<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['username'])  
{  
    header('location: ../login.php');  
    exit;  
}

$_SESSION['username'] = isset($_POST['username']) ? $_POST['username'] : ""; 

if(isset($_POST['envoyer_update'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $reponse = !empty($_POST['reponse']) ? trim($_POST['reponse']) : null;
    
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
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "UPDATE INTO users (username, firstname, lastname, question, reponse)
            VALUES (:username, :firstname, :lastname, :question, :reponse)";
    $stmt = $pdo->prepare($sql);
    
    //Bind our variables.
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':lastname', $lastname);
    $stmt->bindValue(':question', $question);
    $stmt->bindValue(':reponse', $passwordHash);

    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        header("location: profile_updated.php");
    }
    
}

    ?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../style_GBAF.css"/>
        <title>Extranet GBAF</title>
    </head>

        <body>
            <header>
                <?php include("../php/logo.php"); ?>
                
                <div class="title">
                    <h1>Modifier votre profile:</h1>
                </div>
                <div class="profil_connected">
                    <?php include("../php/profile.php"); ?>
                </div>
                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a class="active" href="modifyprofile_copy.php">TEST Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>

            </header>

            <main>
            <div class="title_box">
                <h2>Pour modifier votre profile,<br>veuillez remplir tous les sections demandés:</h2>
            </div>   
            
            <form action="profile_updated.php" method="post" class="option_box">
            
                <label for="username">Votre nouvel identifiant</label>
                <input type="text" id="username" name="username" required><br>
                <br>
                <label for="firstname">Votre nouvel prénom</label>
                <input type="text" id="firstname" name="firstname" required><br>
                <br>
                <label for="lastname">Votre nouvel nom</label>
                <input type="text" id="firtsname" name="lastname" required><br>
                <br>
                <label for="question">Votre nouvelle question sécrete</label>
                <input type="text" id="question" name="question"required><br>
                <br>
                <label for="reponse">Votre nouvelle rèponse sécrete</label>
                <input type="password" id="reponse" name="reponse" required><br>
                <br>
                <input type="submit" name="envoyer_update" value="Envoyer"></button>

                <div class="new_password">
                    <p><a href="forgotpassword.php">Pour changer votre mot de passe, cliquez ici</a></p>
                </div> 
                
            </form>

        <?php include("../php/footer.php"); ?>
    </body>
</html>