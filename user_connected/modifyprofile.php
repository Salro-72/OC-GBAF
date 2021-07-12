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
                
        <div id="container">            
            <div class="option_box">
                <form method="post" action="modifyprofile_post.php"> <!-- tee tähän joku ?? -->
                <div class="row" id="update_profil">
                    <h3>Modifier votre identifiant</h3>
                        <label for="old_username" class="form-label">Ancien identifiant</label>
                        <input type="text" class="form-control" id="old_username" name="old_username">
                </div>
                <br>
                <div class="row" id="update-profil">
                    <label for="update-username" class="form-label">Nouveau identifiant</label>
                    <input type="text" class="form-control" id="update_username" name="new_username"><br>
                </div>

                <div class="row" id="update_profil">
                    <h3>Modifier votre mot de passe</h3>
                        <label for="old-pass" class="form-label">Ancien mot de passe</label>
                        <input type="text" class="form-control" id="odl-pass" name="old-pass">
                </div>
                <br>
                <div class="row" id="update_profil">
                    <label for="update-pass" class="form-label">Nouveau mot de passe</label>
                    <input type="text" class="form-control" id="update-pass" name="new-pass">
                </div>
                <br>
                <div class="row" id="update_profil">
                    <label for="verify_password" class="form-label">Valider  mot de passe</label>
                    <input type="text" class="form-control" id="verify_password" name="verify_password"><br>
                <br>
                <button type="submit" class="btn btn-success" name="updateprofil">Envoyer</button>
        </div>

     <?php include("php/footer.php"); ?>

    </body>

</html>