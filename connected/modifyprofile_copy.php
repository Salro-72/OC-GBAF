<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['pseudo'])  
{  
    header('location: ../login.php');  
    exit;  
}

if(isset($_POST['envoyer_update'])){
    
    $pseudo = $_POST['pseudo'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];

    $passwordHash = password_hash($reponse, PASSWORD_BCRYPT, array("cost" => 12));

    $sql = ('UPDATE users 
            SET pseudo = :pseudo, 
                firstname = :firstname, 
                lastname = :lastname, 
                question = :question, 
                reponse = :reponse 
                WHERE pseudo= :pseudo');
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':reponse', $reponse);

    $result = $stmt->execute();
        
        if (!$result)
        {
            echo 'Erreur !';
        }
            else
            {
                header('Location: profile_updated.php?id='.$_SESSION['id_user']);
                exit;
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
            
            <form action="" method="post" class="option_box">
            
                <label for="pseudo">Votre nouvel identifiant</label>
                <input type="text" id="pseudo" name="pseudo" required><br>
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