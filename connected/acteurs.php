<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['pseudo'])  
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
<!-- acteurs: -->
            <?php
                // Récupération du contenu
                $req = $pdo->prepare('SELECT id, titre, contenu
                FROM billets WHERE id = ?');
                $req->execute(array($_GET['billet']));
                $donnees = $req->fetch();
            ?>

            <div class="news">
                <h3>
                    <?php echo htmlspecialchars($donnees['titre']); ?>
                </h3>
                
                <p>
                <?php
                echo nl2br(htmlspecialchars($donnees['contenu']));
                ?>
                </p>
            </div>
<!-- section ecrire commentaire -->
            <form method="post" action="commentaires_post.php?billet=<?php echo $_GET['billet'];?>">
                    <p>
                    <label for="auteur">Votre identifiant:</label>
                    <input type="text" name="auteur" id="auteur" required/>
                    
                    <label for="commentaire"></label><br />
                    <textarea name="commentaire" id="commentaire" cols="50" rows="5" placeholder="Votre commentaire"></textarea><br />

                    <input type="submit" value="Envoyer" />
                </p>
                </form>
<!-- commentaires -->

            <h2>Commentaires</h2>

            <?php
            $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
            // Récupération des commentaires
                $req = $pdo->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr
                FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
                $req->execute(array($_GET['billet']));

                while ($donnees = $req->fetch())
                {
            ?>
            <p><strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong>, le <?php echo htmlspecialchars($donnees['date_commentaire_fr']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
            <?php
                } // Fin de la boucle des commentaires
                $req->closeCursor();
            ?>
        <?php include("../php/footer.php"); ?>
    </body>
</html>