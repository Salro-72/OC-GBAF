<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['username'])  
{  
    header('location: ../login.php');  
    exit;  
}

date_default_timezone_set('Europe/Paris');

$idActeur = isset($_POST['id_acteur']) ? $_POST['id_acteur'] : '';
$idUser = isset($_POST['id_user']) ? $_POST['id_user'] : ''; {

// B. Ajoute un nouveau commentaire unique
// Cherche si l'utilisateur a déjà commenté
$req_already_comment = $pdo->prepare('SELECT * FROM post WHERE id_user = ? AND id_acteur = ?');
$req_already_comment->execute(array($_SESSION['id_user'], $idActeur));
$userHasComment = $req_already_comment->fetch();
$req_already_comment->closeCursor();

// si il n'a pas déjà commenté
if (!$userHasComment) {

    $formComment = '';

    if (isset($_POST['newCommentPosted']) and !empty($_POST['post'])) {

        $req_insert_comment = $pdo->prepare('INSERT into post (id_user, id_acteur, date_add, post)
                                VALUES (:id_user, :id_acteur, NOW(), :post)
                                ');
        $req_insert_comment->execute(array(
            'id_user' => $_SESSION['id_user'],
            'id_acteur' => $dataActeur['id_acteur'],
            'post' => ($_POST['post'])
        ));
        $req_insert_comment->closeCursor();
    }
}
}

if ($userHasComment) {

    $formComment = 'Vous avez déjà commenté';
}

// C. Compte le nombre de commentaire sur l'acteur
$req_nbr_comments = $pdo->prepare('SELECT COUNT(*) as nbrComments FROM post WHERE id_acteur = ?');
$req_nbr_comments->execute(array($idActeur));
$commentsPosted = $req_nbr_comments->fetch();
$nbrcommentsPosted = $commentsPosted['nbrComments'];
$req_nbr_comments->closeCursor();

// F. Fonction qui affiche tous les commentaires sur l'acteur
function listCommentaires($pdo, $idActeur)
{
    $req_comment = $pdo->prepare('SELECT  p.post as comment, 
                                    DATE_FORMAT(p.date_add, "%d/%m/%Y") as commentDate,
                                    DATE_FORMAT(p.date_add, "%d/%m/%Y %T") as commentDateOrder, 
                                    a.prenom as autorName
                            FROM post p
                            INNER JOIN account a
                            ON p.id_user = a.id_user
                            WHERE p.id_acteur = ?
                            ORDER by commentDateOrder DESC');

    $req_comment->bindValue(1, $idActeur, PDO::PARAM_INT);
    $req_comment->execute();

    while ($dataComment = $req_comment->fetch()) {

        echo '<li>';
        echo '<p>' . htmlspecialchars($dataComment['autorName'])  . '</p>';
        echo '<p>' . $dataComment['commentDate']  . '</p>';
        echo '<p>' . htmlspecialchars($dataComment['comment'])  . '</p>';
        echo '</li>';
    }

    $req_comment->closeCursor();
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
                
                <div>
                    <?php include("../php/profile.php"); ?>
                </div>
                
                    <div class="title">
                    <h1>Formation&co</h1> 
                </div>

                <div class="topnav">
                    <a href="../connected/homepage.php">Acceuil</a>
                    <a class="active" href="../connected/formationco.php">Formation&co</a>
                    <a href="../connected/modifyprofile_copy.php">Modifier votre profile</a>
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
            <main>

            <!-- Section commentaires -->
            <section class="commentaires">
                <div class="commentaires_dynamic">
                    <!-- C. Nombre de commentaires -->
                    <h4> 
                        <?php echo $nbrcommentsPosted; ?> 
                        commentaires 
                    </h4>

                    <!-- Ajouter un nouveau commentaire -->
                    <div class="new_commentaire">
                        <label class="open_popup" for="popup_button"> 
                            Nouveau commentaire
                        </label>
                        <input type="checkbox" id="popup_button"/>
                        <!-- B. fenêtre pop-up du formulaire -->
                        <form 
                            class="new_commentaire_formulaire"
                            method="post"
                            action="#"
                        >
                            <p>
                                <label class="close_popup" for="popup_button"></label>
                                <label for="post"> Ajoutez un nouveau commentaire sur Formation&co </label>
                                <br>
                                <textarea id="post" name="post"><?php echo $formComment; ?></textarea>
                                <input type="submit" value="Envoyer" name="newCommentPosted" />
                            </p>
                        </form>
                    </div>

                <!-- F. Liste de tous les commentaires -->
                <ul class="commentaires-list">
                    <!--<li> -->
                    <?php listCommentaires($pdo, $idActeur); ?>
                </ul>
            </section>

            <aside class="retour-accueil">
                <a href="homepage.php">retour à la page d'accueil</a>
            </aside>
    </main>
        </body>
</html>