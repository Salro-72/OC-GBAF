<?php
session_start();
require 'configs/db.php';

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
                <h1>Bienvenue chez <em>Extranet</em>
                <br>de GBAF</h1>
            </div>

            <div class="option_box">
                <div>
                    <p>Connectez vous à votre espace TEST</p>
                    <p><a href="login.php" class="connexion_button">Connexion</a></p><br>

                    <p>Première visite?</p>
                    <p><a href="signup.php" class="inscritpion_button">Inscription</a></p>
                </div>
            </div>

<?php include("php/footer.php"); ?>

        </body>

</html>
