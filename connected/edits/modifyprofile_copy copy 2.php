<?php
session_start();
require '../configs/db.php';

if(isset($_POST['update'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $question = !empty($_POST['question']) ? trim($_POST['question']) : null;
    $reponse = !empty($_POST['reponse']) ? trim($_POST['reponse']) : null;

$sql = "UPDATE users SET username=?, password=?, question=?, reponse=? WHERE username=:username";
$stmt= $pdo->prepare($sql);
$stmt->execute([$username, $password, $question, $reponse]);

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
                           
            <form action="modifyprofile_copy.php" method="post" class="option_box">

                <h3>Modifier votre profile</h3>
                    <input type="text" name="username" required placeholder="Nouvelle identifiant"><br>
                    <input type="text" name="password" required placeholder="Nouvelle mot de passe"><br>
                    <input type="text" name="question" required placeholder="Nouvelle question"><br>
                    <input type="text" name="reponse" required placeholder="Nouvelle reponse"><br>
 
                    <button type="submit" name="update">Envoyer</button>

        <?php include("../php/footer.php"); ?>

    </body>

</html>