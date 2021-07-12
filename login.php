<?php
session_start();
require 'configs/db.php';

if(isset($_SESSION["userloggedin"]) && $_SESSION["userloggedin"] === TRUE){
    header("location: user_connected/homepage.php");
    exit;
}

$username = $password = "";
$username_error = $password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

if(empty($username_error) && empty($password_error)){

    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $param_username = trim($_POST["username"]);

    if($stmt->execute()){
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()){
                $id = $row["id"];
                $username = $row["username"];
                $hashed_password = $row["password"];
                if(password_verify($password, $hashed_password)){
                    session_start();

                    $_SESSION["userloggedin"] = TRUE;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;

                    header("location: homepage.php");
                } else{
                    $password_error = "The password you entered was not valid.";
                }
            }
            else{
                $username_error = "No account found with that username or email address.â€‹â€‹â€‹â€‹â€‹";
            }
        } else{
          $alert = "Something went wrong. Please Try Again.";
          echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }
    }

unset($pdo);
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
            <h2>Connectez-vous</h2>
            </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="option_box">
                    <div class="label_class"><label>Identifiant</label></div>
                    <div class="input_class"><input type="text" name="username" value="<?php echo $username; ?>" required></div>
                        <span><?php echo $username_error; ?></span>
                    <br>
                    <div class="label_class"><label>Mot de passe</label></div>
                    <div class="input_class"><input type="password" name="password" value="<?php echo $password; ?>" required></div>
                        <span><?php echo $password_error; ?></span>
                    <br>
                    <div class="row">
                        <div class="input_class">
                            <input type="submit" value="Envoyer">
                        </div>
                    </div> 
                    <br>
                   
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