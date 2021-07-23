<?php
session_start();
require '../configs/db.php';
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Mon blog</title>
        <link href="style.css" rel="stylesheet" /> 
        </head>
            
        <body>
            <h1>Mon super blog !</h1>
            <p><a href="protectpeople.php">Retour à la liste des billets</a></p>
<?php
    // Récupération du billet
    $req = $pdo->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') 
    AS date_creation_fr FROM billets WHERE id = ?');
    $req->execute(array($_GET['billet']));
    $donnees = $req->fetch();
    ?>

    <div class="news">
        <h3>
            <?php echo htmlspecialchars($donnees['titre']); ?>
            <em>le <?php echo $donnees['date_creation_fr']; ?></em>
        </h3>
        
        <p>
        <?php
        echo nl2br(htmlspecialchars($donnees['contenu']));
        ?>
        </p>
    </div>
    <p><a href="commentaires_post.php">Ajouter un commentaire</a></p>

    <h2>Commentaires</h2>
    <?php
    $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête

    // Récupération des commentaires
    $req = $pdo->prepare('SELECT id_auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') 
    AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
    $req->execute(array($_GET['billet']));

    while ($donnees = $req->fetch())
    {
    ?>
   
    <p><strong><?php echo htmlspecialchars($donnees['id_auteur']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>
    <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
    <?php
    } // Fin de la boucle des commentaires
    $req->closeCursor();
    ?>
    
    </body>
</html>