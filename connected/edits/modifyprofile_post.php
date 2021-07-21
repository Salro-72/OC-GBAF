<?php
session_start();
require '../configs/db.php';
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
                <p class="profil_connected"><?php echo $_GET['firstname'] . ' ' . $_GET['lastname']; ?> !</p>
                <!-- ajoute ici le nom d'utilisateur connecté -->
                <div class="title">
                    <h1>Modifier votre profil</h1>
                </div>
                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a class="active" href="modifyprofile.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>   
            </header>

            <div class="option_box">
                <h2>Votre profile a été mis à jour!<h2>
                <br>
                <a href="homepage.php">Retournez à la page d'acceuil</a>    
            </div>           
           

        <?php include("../php/footer.php"); ?>

    </body>

</html>