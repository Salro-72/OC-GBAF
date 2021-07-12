<?php
session_start();
require 'configs/db.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="style_GBAF.css"/>
        <title>Extranet GBAF</title>
    </head>

        <body>
            <header>
                <?php include("php/logo.php"); ?>
                <p class="profil_connected"><?php echo $_GET['firstname'] . ' ' . $_GET['lastname']; ?> !</p>
                <!-- ajoute ici le nom d'utilisateur connecté -->
                <div class="title">
                    <h1>Formation&co</h1> 
                </div>

                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a href="modifyprofile.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </header>
            <hr>

<!-- Section acteurs -->
            <section class="acteur">
                <article>
                    <div class="title_acteur">
                        <h1>Formation&co</h1>
                    </div>

                    <div class="row">
                        <div class="column">
                            <img src="GBAF_img/formation_co.png" class="logo_acteur">
                        </div>

                        <div class="column">
                            <div class="text_acteur">
                                <p class="content-acteur">Formation&amp;co est une association française présente sur tout le territoire.<br>
                                Nous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement professionnel et personnalisé.<br>
                                Notre proposition : <br>
                                <li>un financement jusqu’à 30 000€ ;</li>
                                <li>un suivi personnalisé et gratuit ;</li>
                                <li>une lutte acharnée contre les freins sociétaux et les stéréotypes.</li>
                                <br>
                                Le financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… . Nous collaborons avec des personnes talentueuses et motivées.<br>
                                Vous n’avez pas de diplômes ? Ce n’est pas un problème pour nous ! Nos financements s’adressent à tous.<br>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
            <hr>
            
<!-- Section commentaire -->
            <section>
                <div class="notice" id="comment-add">
                    <h3>EXEMPLE 1 commentaire</h3>  <!-- Nombre des commentaires -->  
                        <div class="add_comment">
                            <a href="#text-comment" class="js-modal">Ajouter un commentaire</a>
                        </div>
                        <div class="add-notice">
                            <a href=" " class="likes">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                </svg>J'aime</a> <!-- nombre likes -->
                            <a href="likeanddislike.php?t=2&id=1" class="dislikes">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                </svg>J'aime pas</a> <!-- nombre dislikes -->
                        </div>
                </div>
            </section>
            <br>

                <section>
                <div class="" id="">
                    <form method="POST">
                        <label for="names" class="form-label" id="formComment">Poster un commentaire en tant que :</label>
                        <p>EXEMPLE test</p> <!-- nom d'utilisateur --> 
                        <textarea class="form-control" id="text-comment" name="textcomment" rows="8" required></textarea>
                        <input type="hidden" name="prenom" value="">
                        <button type="submit" id="button_comment" class="btn btn-success" value="formenvoie">Envoyez</button>
                    </form>
                </div>
            </section>

                <section class="comment">
                <div class="card bg-light mb-3" id="card-mb3">
                    <div class="card-header">EXEMPLE De test le : 29-06-2021</div> <!-- date de commentaire -->
                    <div class="card-body" id="card-body">
                        <p class="text-justify">EXEMPLE salut tout le monde</p> <!-- commentaire -->
                    </div>
                </div>
            </section>
    
        </body>
    <?php include("php/footer.php"); ?>
</html>