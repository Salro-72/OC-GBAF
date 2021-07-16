<?php
session_start();
session_destroy();
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

            <p class="title_logout">Vous êtes bien déconnecté</p>
            <br>
            <div class="option_box">
                <div>
                    <p>Connectez-vous à nouveau</p>
                    <p><a href="../login.php" class="connexion_button">Connexion</a></p><br>
                </div>
            </div>

<?php include("../php/footer.php"); ?>

        </body>

</html>