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
 <!-- section présentation: -->
                <div class="sectionpresentations">
                    <h1 class="presentation_title_h1">GBAF</h1>
                    <p class="presentation_text">Le Groupement Banque Assurance Français (GBAF) est une fédération
                    représentant les 6 grands groupes français :
                        <ul class="groupes_list">
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
<!-- section acteurs et partenaires: -->
                <section class="sectionact_part">                    
                    <div class="container_lists">
                        <h2 class="presentation_title_h2">Nos partenaires :</h2>
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
                    
                        <h2 class="presentation_title_h2">Nos acteurs :</h2>
                        <p>
                            <ul>
                                <li>Formation_co</li>
                                <li>Protectpeople</li>
                                <li>DSA France</li>
                                <li>CDE</li>
                            </ul>
                        </p>
                    </div>
                    <hr>
<!-- section acteurs et partenaires textes: -->
                        <div class="row">
                            <div class="column">
                                <img src="../GBAF_img/formation_co.png" class="logo_partenaire" alt="logo-partenaire"/>
                            </div>
                            <div class="column">
                                <h3 class="presentation_title_h3">Formation&co</h3>
                                    <p class="sneakpeak_text">Formation&amp;co est une association française présente sur tout le territoire.
                                    Nous proposons... </p>
                                    <em><a href="../connected/formationco.php" class="read_more">Lire la suite</a></em>
                            </div> 
                        </div>
<hr>
                        <div class="row">
                            <div class="column">
                                <img src="../GBAF_img/protectpeople.png" class="logo_partenaire" alt="logo-partenaire"/>
                            </div>
                            <div class="column">
                                <h3 class="presentation_title_h3">Protectpeople</h3>
                                    <p class="sneakpeak_text">Protectpeople finance la solidarité nationale.
                                    Nous appliquons le principe édifié par la...</p>
                                    <em><a href="../connected/protectpeople.php" class="read_more">Lire la suite</a></em>
                            </div> 
                        </div>
<hr>
                        <div class="row">
                            <div class="column">
                                <img src="../GBAF_img/Dsa_france.png" class="logo_partenaire" alt="logo-partenaire"/>
                            </div>
                            <div class="column">
                                <h3 class="presentation_title_h3">DSA France</h3>
                                    <p class="sneakpeak_text">Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.
                                    Nous accompagnons les entreprises dans... </p>
                                    <em><a href=" " class="read_more">Lire la suite</a></em>
                            </div> 
                        </div>
<hr>
                        <div class="row">
                            <div class="column">
                                <img src="../GBAF_img/CDE.png" class="logo_partenaire" alt="logo-partenaire"/>
                            </div>
                            <div class="column">
                                <h3 class="presentation_title_h3">CDE</h3>
                                    <p class="sneakpeak_text">La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation. 
                                    Son président... </p>
                                    <em><a href=" " class="read_more">Lire la suite</a></em>
                            </div> 
                        </div>
                </section>
        <?php include("../php/footer.php"); ?>
    </body>
</html>