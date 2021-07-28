<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['id_user'])  
{  
    header('location: ../login.php');  
    exit;  
}

// (B) DUMMY POSTS  ID BDDstä
$posts = [
    "1" => "Donnez votre avis :"
  ];
  $pid = [];
  foreach ($posts as $id=>$txt) { $pid[] = $id; }
  
  // cherce votes
  require "votes.php";
  $react = $REACT->get($pid);
  $ureact = $REACT->getUser($pid, $_SESSION['id_user']);
  
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <script src="votes.js"></script>
  </head>
  <body>
    <div id="demo"><?php
        foreach ($posts as $id=>$txt) { 
        $likes = isset($react[$id][1]) ? $react[$id][1] : 0 ;
        $dislikes = isset($react[$id][0]) ? $react[$id][0] : 0 ;
        $reuser = isset($ureact[$id]) ? $ureact[$id] : "" ; ?>
        
        <div class="prow" data-react="<?=$reuser?>" id="prow<?=$id?>">
            <div class="ptxt"><?=$txt?></div>
                <div class="plike" onclick="react(<?=$id?>, 1)">
                <i class="fa fa-thumbs-up"></i>
                <span class="countlike"><?=$likes?></span>
                </div>
        
                <div class="pdislike" onclick="react(<?=$id?>, 0)">
                <i class="fa fa-thumbs-down"></i>
                <span class="countdislike"><?=$dislikes?></span>
                </div>
        </div>
        <?php } ?>
    </div>
<!-- section ecrire commentaire -->    
        <form method="POST" action="commentaires_post.php?billet=<?php echo $_GET['billet'];?>" class="comment_box">
            <p>
                <label for="id_user" class="name_mobile">Veuillez verifier votre identifiant:</label><br>
                <input type="text" name="id_user" id="id_user" placeholder="<?php echo $_SESSION['pseudo'];?>" class="insert_box_mobile" required/>
                <br>
                <label for="commentaire"></label><br />
                <textarea name="commentaire" id="commentaire" cols="50" rows="5" placeholder="Votre commentaire" class="insert_box_mobile" required></textarea><br />
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