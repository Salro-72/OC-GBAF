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
        <?php
            // On récupère les 5 derniers billets
            $req = $pdo->query('SELECT id, titre, firstline, logo_acteur
            FROM billets');

            while ($donnees = $req->fetch())
            {
            ?>

        <div class="row">
        <img class="logo_partenaire">
                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $donnees['logo_acteur'] ).'"/>'?>
            </img> 
           <br>
            <h3 class="presentation_title_h3">
                <?php echo htmlspecialchars($donnees['titre']); ?>
            </h3>
            <br>
            <p class="sneakpeak_text"><?php echo nl2br(htmlspecialchars($donnees['firstline']));?>
                <br />
                <em><a href="acteurs.php?billet=<?php echo $donnees['id']; ?>" class="read_more">Lisez la suite...</a></em>
            </p>
            <br>
        </div>
        <hr>
            <?php
            } // Fin de la boucle des billets
            $req->closeCursor();
            ?>
        <?php include("../php/footer.php"); ?>
    </body>
</html>