<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['username'])  
{  
    header('location: ../login.php');  
    exit;  
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
            </header>

            <p class="title_logout">Votre profile a été mis à jour</p>
            <br>
            <div class="option_box">
                <div>
                    <p>Retour à la page d'accueil</p>
                    <p><a href="homepage.php" class="connexion_button">Accueil</a></p><br>
                </div>
            </div>

<?php include("../php/footer.php"); ?>

        </body>

</html>