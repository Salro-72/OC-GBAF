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
                <input type="text" id="password" name="password"><br>
                <input type="submit" name="connexion" value="Connexion">
            </form>
        </body>
    <?php include("php/footer.php"); ?>
</html><?php

session_start();
require 'configs/db.php';

if(isset($_SESSION["userloggedin"]) && $_SESSION["userloggedin"] === true){
    header("location: user_connected/homepage.php");
    exit;
}

$userinput = $password = "";
$userinput_error = $password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userinput = trim($_POST["userinput"]);
    $password = trim($_POST["password"]);

if(empty($userinput_error) && empty($password_error)){

    $sql = "SELECT id, username, password FROM users WHERE username = :userinput = :userinput";
    if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":userinput", $param_userinput, PDO::PARAM_STR);
    $param_userinput = trim($_POST["userinput"]);

    if($stmt->execute()){
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()){
                $id = $row["id"];
                $userinput = $row["username"];
                $hashed_password = $row["password"];
                if(password_verify($password, $hashed_password)){
                    session_start();

                    $_SESSION["userloggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["userinput"] = $userinput;

                    header("location: homepage.php");
                } else{
                    $password_error = "The password you entered was not valid.";
                }
            }
            else{
                $userinput_error = "No account found with that username or email address.â€‹â€‹â€‹â€‹â€‹";
            }
        } else{
          $alert = "Something went wrong. Please Try Again.";
          echo "<script type='text/javascript'>alert('$alert');</script>";            }
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
                <div class="topnav">
                    <a href="index.php">Retour arriere</a>
                </div>
            </header>
    
            <div class="title_succes">
            <h2>Votre compte a bien été crée !</h2>
            </div>
            <br>
                <p class="connexion">Connectez vous à votre espace membre:</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="option_box">
                    <div class="label_class"><label>Identifiant</label></div>
                    <div class="input_class"><input type="text" name="userinput" value="<?php echo $userinput; ?>" required></div>
                        <span><?php echo $userinput_error; ?></span>
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
                      
                </form>
        </body>
    <?php include("php/footer.php"); ?>
</html>