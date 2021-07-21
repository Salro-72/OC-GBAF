<?php
session_start();
require '../configs/db.php';

date_default_timezone_set('Europe/Paris');

if($_POST['submit_commentaire']) {
    if(isset($_POST['identifiant'], $_POST['commentaire'])
    AND !empty($_POST['identifiant']) AND !empty($_POST['commentaire']));
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
    <form method="POST">
        <textarea name="commentaire" placeholder="Votre commentaire"></textarea><br>
        <input type="submit" value="Envoyer" name="submit_commentaire"></input>
    </form>


        </body>
</html>