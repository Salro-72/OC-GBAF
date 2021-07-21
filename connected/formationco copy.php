<?php
session_start();
require '../configs/db.php';


if (isset($_POST['commentSubmit'])) {
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $message = !empty($_POST['message']) ? trim($_POST['message']) : null;

    $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':username', $username);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO commentsection (message) VALUES (:message)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':message', $message);

    $result = $stmt->execute();

    if($result){
        echo 'Commentaire bien ajouté';
    }
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
                    <h1>Formation&co</h1> 
                </div>

                <div class="topnav">
                    <a href="../connected/homepage.php">Acceuil</a>
                    <a href="../connected/modifyprofile.php">Modifier votre profile</a>
                    <a href="../connected/logout.php">Déconnexion</a>
                </div>
            </header>

<!-- Section acteurs -->
            <section>
                <article>
                    <div>
                        <div>
                            <img src="../GBAF_img/formation_co.png" class="logo_acteur">
                        </div>
                            
                        <div class ="presentation_act">
                            <p>Formation&co est une association française présente sur tout le territoire.<br>
                            Nous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un 
                            crédit et un accompagnement professionnel et personnalisé.
                            <br>
                            <br>
                            Notre proposition : <br>
                                <li>un financement jusqu’à 30 000€ ;</li>
                                <li>un suivi personnalisé et gratuit ;</li>
                                <li>une lutte acharnée contre les freins sociétaux et les stéréotypes.</li>
                                <br>
                            Le financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… Nous collaborons avec des personnes talentueuses et motivées.<br>
                            Vous n’avez pas de diplômes ? Ce n’est pas un problème pour nous ! Nos financements s’adressent à tous.<br>
                        </div>
                    </div>
                </article>
            </section>
<hr>          
<!-- Section commentaire -->
            
        <h2>Commentaires:<h2>
            <form action="formationco.php" method="POST">
                <textarea name="message" placeholder="Votre commentaire"></textarea><br>
                <button type="submit" name="commentSubmit">Comment</button>
            </form>
                <?php getComments($pdo);?>

        </body>
</html>