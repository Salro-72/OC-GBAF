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
                $req = $pdo->prepare('SELECT id, titre, contenu, logo_acteur, like_count, dislike_count
                FROM billets WHERE id = ?');
                $req->execute(array($_GET['billet']));
                $donnees = $req->fetch();
            ?>

            <div class ="presentation_act">
                <img>
                    <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $donnees['logo_acteur'] ).'"/>'?>
                </img>    
                <h3>
                    <?php echo htmlspecialchars($donnees['titre']); ?>
                </h3>  
                <p>
                    <?php echo nl2br(htmlspecialchars($donnees['contenu']));?>
                </p>
            </div>
            <hr>
<!-- section likes/dislikes -->
        <div class="vote">
        <form action="likes.php?ref=billets&ref_id=?&vote1" method="POST"> 
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
                <button type="submit" class="vote_btn vote_like"><i class="fa fa-thumbs-up" 
                    style="font-size:24px"> <?php echo htmlspecialchars($donnees['like_count']); ?></i></button>
            </form>
            <br> 
            <form action="likes.php?ref=billets&ref_id=?&vote-1" method="POST"> 
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
                <button type="submit" class="vote_btn vote_dislike"><i class="fa fa-thumbs-down" 
                    style="font-size:24px"> <?php echo htmlspecialchars($donnees['dislike_count']); ?></i></button>
            </form>
            <br>
        </div>
<!-- section ecrire commentaire -->
        <form method="post" action="commentaires_post.php?billet=<?php echo $_GET['billet'];?>" class="comment_box">
            <p>
                <label for="id_user">Veuillez verifier votre identifiant:</label><br>
                <input type="text" name="id_user" id="id_user" placeholder="<?php echo $_SESSION['pseudo'];?>" required/>
                <br>
                <label for="commentaire"></label><br />
                <textarea name="commentaire" id="commentaire" cols="50" rows="5" placeholder="Votre commentaire" required></textarea><br />
                <input type="submit" value="Envoyer" />
            </p>
        </form>
<!-- commentaires -->
        <h2>Commentaires</h2>
            <p class="comment_everyone">
                <?php $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
                // Récupération des commentaires
                $req = $pdo->prepare('SELECT id_user, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr
                FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
                $req->execute(array($_GET['billet']));

                while ($donnees = $req->fetch())
                {
                ?>
            </p>

            <p><strong><?php echo htmlspecialchars($donnees['id_user']); ?></strong>, le <em><?php echo htmlspecialchars($donnees['date_commentaire_fr']); ?></em></p>
            <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
            <?php
                } // Fin de la boucle des commentaires
                $req->closeCursor();
            ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
        <?php include("../php/footer.php"); ?>
    </body>
</html>