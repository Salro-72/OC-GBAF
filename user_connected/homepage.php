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
                    <h1>Bienvenue chez extranet GBAF</h1>
                </div>

                <div class="topnav">
                    <a class="active" href="homepage.php">Acceuil</a>
                    <a href="modifyprofile.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </header>

 <!-- section présentation: -->
            <section class="sectionpresentations">
                <article>
                    <div class="presentation">
                        <h1 class="presentation_title_h1">GBAF</h1>
                        <p>Le Groupement Banque Assurance Français (GBAF) est une fédération
                            représentant les 6 grands groupes français :
                        <ul>
                            <li>BNP Paribas ;</li>
                            <li>BPCE ;</li>
                            <li>Crédit Agricole ;</li>
                            <li>Crédit Mutuel-CIC ;</li>
                            <li>Société Générale ;</li>
                            <li>La Banque Postale.</li>
                        </ul>
                        </p>
                        <p class="presentation_text"> Le GBAF est le représentant de la profession bancaire et des assureurs
                            sur tous les axes de la réglementation financière française. Sa mission est de promouvoir
                            l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des
                            pouvoirs publics.
                        </p>
                    </div>
                </article>
            </section>
            <hr>
            
<!-- section acteurs et partenaires: -->
            <section class="sectionact_part">
                <h2 class="presentation_title_h2">Section acteurs</h2><br>
                    <div class="acteur_list">
                       
                    <div class="container_list_partenaire">
                        <h3>Nos partenaires :</h3>
                        <p>
                        <ul>
                            <li>BNP Paribas </li>
                            <li>BPCE </li>
                            <li> Crédit Agricole </li>
                            <li>Crédit Mutuel-CIC </li>
                            <li>Société Générale </li>
                            <li>La Banque Postale</li>
                        </ul>
                        </p>
                    </div>
                    
                    <div class="container_list_acteur">
                        <h3>Nos acteurs :</h3>
                        <p>
                        <ul>
                            <li>Formation_co</li>
                            <li>Protectpeople</li>
                            <li>DSA France</li>
                            <li>CDE</li>
                        </ul>
                        </p>
                    </div>
                    </div>
                </div>
            </section>        
            <hr>

<!-- section acteurs et partenaires textes: -->
                <section class="sectionact_part">
                    <article>
                        <div class="box" id="box_partenaire">
                            <div>
                                <img src="GBAF_img/formation_co.png" class="logo_partenaire" alt="logo-partenaire"/>
                            </div>
                            <div>
                                <h3 class="presentation_title_h3">Formation&co</h3>
                                    <p class="presentation_text">Formation&amp;co est une association française présente sur tout le territoire.
                                    Nous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement professionnel et personnalisé.
                                    Notre proposition : 
                                    <ul>
                                        <li>un financement jusqu’à 30 000€ ;</li>
                                        <li>un suivi personnalisé et gratuit ;</li>
                                        <li>une lutte acharnée contre les freins sociétaux et les stéréotypes.</li>
                                    </ul>
                                    Le financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… . Nous collaborons avec des personnes talentueuses et motivées.
                                    Vous n’avez pas de diplômes ? Ce n’est pas un problème pour nous ! Nos financements s’adressent à tous.
                                    </p>
                                <em><a href="pageacteur_formationco.php" class="read_more">Lire la suite</a></em>
                            </div>
                        </div>
                    </article>
                </section>

                <section class="sectionact_part">
                <article>
                    <div class="box" id="box_partenaire">
                    <div class="row no-gutters">
                        <div class="col-md-4" id="logo-card">
                            <img src="GBAF_img/protectpeople.png" class="logo_partenaire" alt="logo-partenaire" />
                        </div>
                        <div>
                            <div>
                                <h3 class="presentation_title_h3">Protectpeople </h3>
                                    <p class="presentation_text">Protectpeople finance la solidarité nationale.
                                    Nous appliquons le principe édifié par la Sécurité sociale française en 1945 : permettre à chacun de bénéficier d’une protection sociale.

                                    Chez Protectpeople, chacun cotise selon ses moyens et reçoit selon ses besoins.
                                    Proectecpeople est ouvert à tous, sans considération d’âge ou d’état de santé.
                                    Nous garantissons un accès aux soins et une retraite.
                                    Chaque année, nous collectons et répartissons 300 milliards d’euros.
                                    Notre mission est double :
                                    <ul>
                                        <li>sociale : nous garantissons la fiabilité des données sociales ;</li>
                                        <li>économique : nous apportons une contribution aux activités économiques.</li>
                                    </ul>
                                    </p>
                                <em><a href="pageacteur.php?id=2" class="read_more">Lire la suite</a></em>
                            </div>
                        </div>
                    </div>
                    </div>
                </article>
                </section>

                <section class="sectionact_part">
                <article>
                    <div class="box" id="box_partenaire">
                    <div class="row no-gutters">
                        <div>
                            <img src="GBAF_img/Dsa_france.png" class="logo_partenaire" alt="logo-partenaire"/>
                        </div>
                        <div>
                            <div>
                                <h3 class="presentation_title_h3">Dsa France</h3>
                                    <p class="presentation_text">Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.
                                    Nous accompagnons les entreprises dans les étapes clés de leur évolution.
                                    Notre philosophie : s’adapter à chaque entreprise.
                                    Nous les accompagnons pour voir plus grand et plus loin et proposons des solutions de financement adaptées à chaque étape de la vie des entreprises
                                    </p>
                                <em><a href="pageacteur.php?id=3" class="read_more">Lire la suite</a></em>
                            </div>
                        </div>
                    </div>
                    </div>
                </article>
                </section>

                <section class="sectionact_part">
                <article>
                    <div class="box" id="box_partenaire">
                    <div class="row no-gutters">
                        <div class="col-md-4" id="logo-card">
                            <img src="GBAF_img/CDE.png" class="logo_partenaire" alt="logo-partenaire" />
                        </div>
                        <div>
                            <div>
                                <h3 class="presentation_title_h3">CDE</h3>
                                <p class="presentation_text">La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation. 
                                Son président est élu pour 3 ans par ses pairs, chefs d’entreprises et présidents des CDE.
                                </p>
                            <em><a href="pageacteur.php?id=4" class="read_more">Lire la suite</a></em>
                            </div>
                        </div>
                    </div>
                    </div>
                </article>
                </section>
                <hr>

        <?php include("php/footer.php"); ?>
    </body>
</html>