<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['id_user'])  
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    </head>
        <body>
            <header>
            <div class="profil_connected">
                <?php include("../php/logo.php"); ?>
                <div>
                <div class="title">
                    <h1>Bienvenue chez extranet GBAF</h1>
                </div>
                <div>
                    <?php include("../php/profile.php"); ?>
                </div>
                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a href="modifyprofile.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </header>
<!-- acteurs: -->
            <?php
                // Récupération du contenu
                $req = $pdo->prepare('SELECT id_acteur, title, contenu, logo_acteur
                FROM acteurs WHERE id_acteur = ?');
                $req->execute(array($_GET['billet']));
                $donnees = $req->fetch();
            ?>

            <div  class ="presentation_act">
                <img class="logoacteur_comment">
                    <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $donnees['logo_acteur'] ).'"/>'?>
                </img>    
                    <h3>
                        <?php echo htmlspecialchars($donnees['title']); ?>
                    </h3>  
                    <p>
                        <?php echo nl2br(htmlspecialchars($donnees['contenu']));?>
                    </p>
            </div>
            <hr>
<!-- section likes/dislikes -->

<!-- MIS À JOUR -->
            <form method="POST" action="votes_post.php?billet=<?php echo $_GET['billet'];?>">
                <?php
                    $req = $pdo->prepare('SELECT COUNT(*) as dislikes FROM votes WHERE id_acteur = ? AND vote = 0');
                    $req->execute(array($_GET['billet']));
                    $dislikes = $req->fetch(PDO::FETCH_ASSOC)['dislikes'];
                    $req->closeCursor();

                    $req = $pdo->prepare('SELECT COUNT(*) as likes FROM votes WHERE id_acteur = ? AND vote = 1');
                    $req->execute(array($_GET['billet']));
                    $likes = $req->fetch(PDO::FETCH_ASSOC)['likes'];
                    $req->closeCursor();

                    // Ici on vérifie si l'utilisateur a voté
                    $req = $pdo->prepare('SELECT vote FROM votes WHERE id_acteur = ? AND id_user = ?');
                    $req->execute(array($_GET['billet'], $_SESSION['id_user']));
                    $number = $req->rowCount();
                    //si $number = 0, çela veux dire qu'il n'a pas voté, sinon il a voté
                    if($number) {
                        $fetch = $req->fetch(PDO::FETCH_ASSOC);
                        $like = $fetch['vote'];
                    }
                ?>
                <div id="demo">
                    <div class="prow">
                        <div class="ptxt">Donnez votre avis:</div>
                            <div class="plike">
                                <i class="fa fa-thumbs-up" 
                                    <?php 
                                        if ($number && $like == 1)
                                            echo 'style="color:green;"';
                                    ?>>
                                    <input type="submit" name="vote" value="J'aime" class="submit_button">
                                </i>
                                <span class="countlike"><?=$likes?></span>
                            </div>
                            <div class="pdislike">
                                <i class="fa fa-thumbs-down"                             
                                    <?php 
                                        if ($number && $like == 0)
                                            echo 'style="color:red;"';
                                    ?>>
                                    <input type="submit" name="vote" value="Je n'aime pas" class="submit_button">
                                </i>                            
                                <span class="countdislike"><?=$dislikes?></span>
                            </div>
                    </div>
                </div>
            </form>
                <br>
<!-- section ecrire commentaire --> 

<!-- MIS À JOUR -->
        <form method="POST" action="commentaires_post.php?billet=<?php echo $_GET['billet'];?>" class="comment_box">
                <input for="id_user" type="text" name="id_user" id="id_user" value="<?php echo $_SESSION['pseudo'];?>" class="name_mobile" />
                <br><br>
                <label for="id_user" class="name_mobile">Veuillez laisser votre commentaire :</label>
                <label for="commentaire"></label><br />
                <textarea name="comment" id="comment" cols="50" rows="5" placeholder="Votre commentaire" class="insert_box_mobile" required></textarea><br />
                <input type="submit" value="Envoyer" class="submit_button">
            </p>
        </form>
<!-- commentaires -->
        <div class="nb_comment">
            <?php $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
                
                // Récupération nombre des commentaires
                $req = $pdo->prepare('SELECT id_acteur, COUNT(*) AS nb_messages FROM comments WHERE id_acteur = ?');
                $req->execute(array($_GET['billet']));
                while ($donnees = $req->fetch())
                {
            ?>
                <p class="title_comments"><strong>Nombre des commentaire(s) : <?php echo htmlspecialchars($donnees['nb_messages']); ?></strong></p>
            <?php
                } // Fin de la boucle des commentaires
                $req->closeCursor();
            ?>
        </div>
            <p class="comment_everyone">
                <?php $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
                
                // Récupération des commentaires
                $req = $pdo->prepare('SELECT id_user, comment, DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr
                FROM comments WHERE id_acteur = ? ORDER BY date_comment');
                $req->execute(array($_GET['billet']));

                while ($donnees = $req->fetch())
                {
                ?>
            </p>

            <p><strong><?php echo htmlspecialchars($donnees['id_user']); ?></strong>, le <em><?php echo htmlspecialchars($donnees['date_comment_fr']); ?></em></p>
            <p><?php echo nl2br(htmlspecialchars($donnees['comment'])); ?></p>
            <?php
                } // Fin de la boucle des commentaires
                $req->closeCursor();
            ?>
        <br>
        <br>
        <br>
        
        <?php include("../php/footer.php"); ?>
    </body>
</html>