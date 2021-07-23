<?php
session_start();
require '../configs/db.php';
include '../php/comment_inc.php';

if (!$_SESSION['pseudo'])  
{  
    header('location: ../login.php');  
    exit;  
}

if (isset($_POST['commentSubmit'])) {
    $pseudo = !empty($_POST['pseudo']) ? trim($_POST['pseudo']) : null;
    $comment = !empty($_POST['comment']) ? trim($_POST['comment']) : null;

    $sql = "SELECT COUNT(pseudo) AS num FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':pseudo', $pseudo);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO commentsection (comment) VALUES (:comment)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':comment', $comment);

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
                <div class="title">
                    <h1>Bienvenue chez extranet GBAF</h1>
                </div>
                <div>
                    <?php include("../php/profile.php"); ?>
                </div>
                <div class="topnav">
                    <a class="active" href="homepage.php">Acceuil</a>
                    <a href="modifyprofile_copy.php">TEST Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
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
            <form action="formationco_test2.php" method="POST">
                <textarea name="comment" placeholder="Votre commentaire"></textarea><br>
                <button type="submit" name="commentSubmit">Comment</button>
            </form>

        </body>
</html>