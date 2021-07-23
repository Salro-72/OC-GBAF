<?php
session_start();
require 'configs/db.php';
include 'configs/account.php';

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
            </header>

            <div class="title">
            <h2>Veuillez changer votre mot de passe</h2>
            </div>
                <div class="inscription_box">
                    <form method="POST" action="">
                 



                        <input type="submit" name="suivant" value="Suivant"/>
                        </p>
                    </form>
                    <br>
                    <a href="index.php"> Retour à l'acceuil </a>
                </div>    
        </body>
    <?php include("php/footer.php"); ?>
</html>