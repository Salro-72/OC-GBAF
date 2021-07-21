<?php
session_start();
require '../configs/db.php';

if(isset($_POST['updateprofil'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $reponse = !empty($_POST['reponse']) ? trim($_POST['reponse']) : null;
}

    $currentUser = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = '$currentUser'";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
                           
            <form action="modifyprofile_post.php" method="post" class="option_box">

                    <h3>Modifier votre identifiant</h3>
                        <label for="old_username">Ancien identifiant</label>
                        <input type="text" id="old_username" name="old_username">
                        <br>
                        <label for="update-username">Nouveau identifiant</label>
                        <input type="text" id="update_username" name="new_username"><br>
 
                    <h3>Modifier votre mot de passe</h3>
                        <label for="old-pass">Ancien mot de passe</label>
                        <input type="text" id="odl-pass" name="old-pass">

                        <label for="update-pass">Nouveau mot de passe</label>
                        <input type="text" id="update-pass" name="new-pass">
                        <br>
                        <label for="verify_password">Valider  mot de passe</label>
                        <input type="text" id="verify_password" name="verify_password"><br>

                    <h3>Modifier votre question secrete</h3>
                        <label for="old_username">Ancien question secrete</label>
                        <input type="text" id="old_username" name="old_username">
                        <br>
                        <label for="update-username">Nouveau question secrete</label>
                        <input type="text" id="update_username" name="new_username"><br>

                    <h3>Modifier reponse secrete</h3>
                        <label for="old_username">Ancien reponse secrete</label>
                        <input type="text" id="old_username" name="old_username">
                        <br>
                        <label for="update-username" >Nouveau reponse secrete</label>
                        <input type="text" id="update_username" name="new_username"><br>

                <button type="submit" name="updateprofil">Envoyer</button>

        <?php include("../php/footer.php"); ?>

    </body>

</html>