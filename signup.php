<?php
session_start();
require 'configs/db.php';

$username = $password = $firstname = $lastname = $question = $reponse = "";
$username_error = $password_error = $firstname_error = $lastname_error = $question_error = $reponse_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql = "SELECT id FROM users WHERE username = :username";

    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $param_username = trim($_POST["username"]);

        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                $username_error = "Cet identifiant est déjà pris.";
            } else{
                $username = trim($_POST["username"]);
            }
        } else{
            echo "Attention! Quelque chose ne va pas, essayez à nouveau plus tard.";
        }
    }

    if(strlen(trim($_POST["password"])) < 8){
        $password_error = "Mot de passe doit contenir au moins 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

// Si tout va bien, on ajoute un utilisateur dans le bdd

    if(empty($username_error) && empty($password_error) && empty($firstname_error) && empty($lastname_error) && empty($question_error) && empty($reponse_error)){

        $sql = "INSERT INTO users (username, password, firstname, lastname, question, reponse) VALUES (:username, :password, :firstname, :lastname, :question, :reponse)";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
            $stmt->bindParam(":question", $param_question, PDO::PARAM_STR);
            $stmt->bindParam(":reponse", $param_reponse, PDO::PARAM_STR);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_question = $question;
            $param_reponse = password_hash($reponse, PASSWORD_DEFAULT);

            if($stmt->execute()){
                header("location: login_new.php");
            } else{
                $alert = "Désolé! Il y avait un erreur. Veuillez essayer à nouveau.";
                echo "<script type='text/javascript'>alert('$alert');</script>";
            }
        }
    }
    unset($pdo);
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
            
            <div class="title">
            <h2>Veuillez remplir tous les sections demandés:</h2>
            </div>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="option_box">
                   
                    <div class="row" <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>>
                        <div><label>Identifiant</label></div>
                        <div><input type="text" name="username" value="<?php echo $username; ?>" required></div>
                        <span><?php echo $username_error; ?></span>
                    </div>
                    
                    <div class="row" <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>>
                        <div><label>Mot de passe</label></div>
                        <div><input type="password" name="password" value="<?php echo $password; ?>" required></div>
                        <span><?php echo $password_error; ?></span>
                    </div>
                    
                    <div class="row" <?php echo (!empty($firstname_error)) ? 'has-error' : ''; ?>>
                        <div><label>Prénom</label></div>
                        <div><input type="text" name="firstname" value="<?php echo $firstname; ?>" required></div>
                        <span><?php echo $firstname_error; ?></span>
                    </div>

                    <div class="row" <?php echo (!empty($lastname_error)) ? 'has-error' : ''; ?>>
                        <div><label>Nom</label></div>
                        <div><input type="text" name="lastname" value="<?php echo $lastname; ?>" required></div>
                        <span><?php echo $lastname_error; ?></span>
                    </div>

                    <div class="row" <?php echo (!empty($question_error)) ? 'has-error' : ''; ?>>
                        <div><label>Question secrète</label></div>
                        <div><input type="text" name="question" value="<?php echo $question; ?>" required></div>
                        <span><?php echo $question_error; ?></span>
                    </div>

                    <div class="row" <?php echo (!empty($reponse_error)) ? 'has-error' : ''; ?>>
                        <div><label>Réponse secrète</label></div>
                        <div><input type="password" name="reponse" value="<?php echo $reponse; ?>" required></div>
                        <span><?php echo $reponse_error; ?></span>
                    </div>
                    
                    <br>

                    <div class="row">
                    <div>
                        <input type="submit" value="Envoyer">
                    </div>

                    <form action="signup.php" method="post">
                        <p>Déjà un compte? <a href="login.php">Connexion</a>
                    </form>

                </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>