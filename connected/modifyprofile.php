<?php
session_start();
require '../configs/db.php';
require_once('../configs/function.php');

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
                    <a href="homepage.php">Acceuil</a>
                    <a class="active" href="modifyprofile_copy.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
            </header>
<body>
<!--  Charge le header --->
    <section class="informations_user">
        <div class="h1_moncompte_center">
            <h1> Mon compte à l'extranet GBAF</h1>
        </div>
        <p>Retrouvez sur cette page toutes vos informations personnelles (nom, prénom, identifiant, ...), vos commentaires, vos likes et bien plus encore!
            C'est également ici que vous pourrez modifier vos données (mot de passe, identifiant, ...)</p>
<!-- formulaire de modification des informations personnelles-->   
        <div class="infos_perso">
            <h2> Mes informations personnelles</h2>
            <p>Vous trouverez ci-dessous vos informations personnelles. Ces dernières sont facilement modifiables.</p>    
            <div class="formulaire_infos_perso">
                <form action="modifyprofile_copy.php" method="post">
                <div class="formulaire_nom">
                        <label for="lastame"><strong>Votre nom actuel :</strong></label>
                        <br>
                        <input type="text" id="name" name="lastname" value="<?php echo isset($_POST['lastname'])? strtoupper($_POST['lastname']) : $_SESSION['lastname'];?>" autofocus required>
                        <!-- champ pour le nom avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                    <br>

                    <div class="formulaire_firstname">
                        <label for="surname"><strong>Votre prénom actuel :</strong></label>
                        <br>
                        <input type="text" id="surname" name="firstname" value="<?php echo isset($_POST['firstname'])? $_POST['firstname'] : $_SESSION['firstname'];?>" required>
                        <!-- champ pour le prélastname avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                        <br>
                    <input id="ancre_name" type="submit" value="Modifier" class="button_submit">
                    <?php 
                    if (isset ($_POST['lastname']) && ($_POST['firstname']))
                    // vérifie si les variables sont déclarées et sont différentes de null.
                    {
                        $reponse = $pdo->prepare('UPDATE users SET lastname = upper(:lastname), firstname = :firstname 
                                                WHERE pseudo = :pseudo');
                        // met à jour toutes les informations du formulaire en base dans la table "user"
                        $reponse->execute(array(
                            'lastname' => $_POST['lastname'],
                            'firstname' => $_POST['firstname'],
                            'pseudo' => $_SESSION['pseudo']
                        ));
                        $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                
                        $reponse = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
                        // va chercher dans la pdo toutes les informations de la table user de la la ligne correspondant au pseudo présent en session
                        $reponse->execute(array(
                            'pseudo' => $_SESSION['pseudo'],
                        ));
                        $donnees = $reponse->fetch();
                        
                        // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos perso)
                
                        $lastname = $donnees['lastname'];
                        $_SESSION['lastname'] = $lastname;
                        $firstname = $donnees['firstname'];
                        $_SESSION['firstname'] = $firstname;                
                    ?>
                            <br>
                    <br>
                    <div class="msg_success"> <!-- message pour informer l'utilisateur que les informations de son compte ont été modifiée-->
                    <p style="color:green;">Félicitation, vos informations ont été modifiées avec succès!</p>
                    </div>
                    <?php
                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                }  
                    ?>
                </form>
        </div>
    </div>
    
    <div class="separator"></div>
<!-- formulaire de modification pseudo--> 
    <div class="infos_perso">
        <h2>
            Mes informations de connexion
        </h2>
        <p>
            Vous trouverez ci-dessous vos informations de connexion. Il vous est possible de changer votre identifiant.
        </p>
        <div class="formulaire_infos_perso">
            <form action="moncompte.php" method="post"> <!-- forumulaire de modification des informations personnelles-->
                    <div class="formulaire_identifiant">
                        <label for="identifiant"><strong>Identifiant :  </strong></label>
                        <br>
                        <input type="text" id="identifiant" name="pseudo" value="<?php echo isset($_POST['pseudo'])? $_POST['pseudo'] : $_SESSION['pseudo'];?>" required> <!-- champ pour l'identifiant avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                    <br>
                    <div class="pass">
                        <label for="pass"><strong>Mot de passe actuel : </strong></label>
                        <br>
                        <input type="password" id="actualpass" name="actualpass" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" required> <!-- champ pour le mot de passe avec regex pour restriendre le choix à des conditions particlières -->
                    </div>
                    <br>
                    <div class="pass">
                        <label for="pass"><strong>Nouveau mot de passe (Minimum : 8 à 15 caractères, 1 majuscule, 1 miniscule, 1 chiffre, 1 caractère spécial ) :  </strong></label>
                        <br>
                        <input type="password" id="pass" name="password" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" required> <!-- champ pour le mot de passe avec regex pour restriendre le choix à des conditions particlières -->
                    </div>
                    <br>
                    <div class="repass">
                        <label for="repass"><strong>Retapez votre nouveau mot de passe :  </strong></label>
                        <br>
                        <input type="password" id="repass" name="repassword" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$" required> <!-- champ pour la vérification du mot de passe avec regex pour restriendre le choix à des conditions particlières -->
                    </div>
                    <br>
                <input type="submit" value="Modifier" class="button_submit">
                <?php 
                if (isset ($_POST['pseudo']) && ($_POST['actualpass']) && ($_POST['password']) && ($_POST['repassword']))
                // vérifie si les variables sont déclarées et sont différentes de null.
                {
                    if ($_POST['password'] === $_POST['repassword']) // vérifie si les mots de passe entrés dans les deux champs sont identiques.
                    {
                        $password = $_POST['password']; 
                        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $password)) // vérifie si le mot de passe respecte la régle imposée : 8 à 15 caractères, 1 majuscule minimum, 1 miniscule minimum, 1 chiffre minimum, 1 caractère spécial.
                        {
                            $reponse = $pdo->prepare('SELECT pseudo, password FROM users WHERE pseudo = :pseudo'); // va chercher dans la pdo si le "pseudo" défini dans le formulaire est présent en base
                            $reponse->execute(array(
                                'pseudo' => $_POST['pseudo'],
                            ));
                                $donnees = $reponse->fetch();
                                
                                $passcheck = password_verify($_POST['actualpass'], $donnees['password']); // compare le mot de passe actuel avec celui en base
            
                            if ($passcheck) // si la comparaison est ok
                            {
                                if (($donnees == false) || ($donnees['pseudo'] === $_SESSION['pseudo'])) // si le "pseudo" n'a pas été trouvé, il est donc libre || ou si le pseudo entré et le même que celui en session
                                {
                                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                                    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT); // crée une clé de hachage pour le mot de passe
                                    $reponse = $pdo->prepare('UPDATE users SET pseudo = :pseudo, password = :password WHERE id_user = :id_user'); // met à jour la table user avec le mot de passe et le pseudo
                                    $reponse->execute(array(
                                        'pseudo' => $_POST['pseudo'],
                                        'password' => $pass_hache,
                                        'id_user' => $_SESSION['id_user']
                                    ));
                                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                                    $reponse = $pdo->prepare('SELECT * FROM users WHERE id_user = :id_user'); // récupére les nouvelles données de la table user suite au précédent update
                                    $reponse->execute(array(
                                        'id_user' => $_SESSION['id_user']
                                    ));
                                    $donnees = $reponse->fetch();
                                    // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos de connexion)
            
                                    $pseudo = $donnees['pseudo'];
                                    $_SESSION['pseudo'] = $pseudo;
                                    
                                    ?> 
                                    <br>
                                    <br>
                                    <div class="msg_success">  <!-- message pour informer l'utilisateur que ses informations de connexion ont été modifié-->
                                    <p style="color:green;">Les modifications ont été apportées avec succès!</p>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?> 
                                    <br>
                                    <br>
                                    <div class="msg_error"> <!-- message pour informer l'utilisateur que le "pseudo" est déjà pris - présent en base-->
                                    <p style="color:red;">Cet identifiant est déjà pris, merci d'en choisir un autre</p>
                                    </div>
                                    <br>
                                    <?php    
                                }   
                            }
                            else
                            {
                                ?> 
                                <br>
                                <br>
                                <div class="msg_error"> <!-- message pour informer l'utilisateur que le mot de passe n'est pas bon-->
                                <p style="color:red;">Votre mot de passe actuel n'est pas bon, merci de corriger votre saisie.</p>
                                </div>
                                <br>
                                <?php  
                            }        
                        }  
                        else
                        {
                            ?> 
                            <br>
                            <br>
                            <div class="msg_error"> <!-- message pour informer l'utilisateur que le mot de passe ne respecte pas la régle-->
                            <p style="color:red;">Votre mot de passe ne respecte pas la régle imposée : 8 à 15 caractères, 1 majuscule minimum, 1 miniscule minimum, 1 chiffre minimum, 1 caractère spécial.</p>
                            </div>
                            <br>
                            <?php  
                        }
                    }
                    else
                    {
                        ?> 
                        <br>
                        <br>
                        <div class="msg_error"> <!-- message pour informer l'utilisateur que les mots de passe saisis ne sont pas identiques-->
                        <p style="color:red;">Vos mots de passe ne sont pas identiques, merci de corriger votre saisie.</p>
                        </div>
                        <br>
                        <?php      
                    }
                }  
                ?>
            </form>
        </div>
    </div>
    <div class="separator"></div>

<!-- formulaire de modification question secrete--> 
<div class="infos_perso">
            <h2> Changer mon question secrete</h2>
            <p>Vous trouverez ci-dessous un formulaire vous permettant de changer votre question secrète. 
                Celle-ci est utilisée pour changer de mot de passe lorsque vous oubliez ce dernier.
            </p>
            <div class="formulaire_infos_perso">
                <form action="modifyprofile_copy.php" method="post">
                <div class="formulaire_question">
                        <label for="question"><strong>Votre ancien question :</strong></label>
                        <br>
                        <input type="text" id="question" name="question" <?php echo isset($_POST['question'])? $_POST['question'] : $_SESSION['question'];?> autofocus required>
                        <!-- champ pour le question avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                    <br>

                    <div class="formulaire_reponse">
                        <label for="reponse"><strong>Votre ancienne reponse :</strong></label>
                        <br>
                        <input type="text" id="reponse" name="reponse" value="<?php echo isset($_POST['reponse'])? $_POST['reponse'] : $_SESSION['reponse'];?>" required>
                        <!-- champ pour le reponse avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                        <br>
                    <input id="ancre_name" type="submit" value="Modifier" class="button_submit">
                    <?php 
                    if (isset ($_POST['question']) && ($_POST['reponse']))
                    // vérifie si les variables sont déclarées et sont différentes de null.
                    {
                        $reponse = $pdo->prepare('UPDATE users SET question = :question, reponse = :reponse 
                                                WHERE pseudo = :pseudo');
                        // met à jour toutes les informations du formulaire en base dans la table "user"
                        $reponse->execute(array(
                            'question' => $_POST['question'],
                            'reponse' => $_POST['reponse'],
                            'pseudo' => $_SESSION['pseudo']
                        ));
                        $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                
                        $reponse = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
                        // va chercher dans la pdo toutes les informations de la table user de la la ligne correspondant au pseudo présent en session
                        $reponse->execute(array(
                            'pseudo' => $_SESSION['pseudo'],
                        ));
                        $donnees = $reponse->fetch();
                        
                        // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos perso)
                
                        $question = $donnees['question'];
                        $_SESSION['question'] = $question;
                        $reponse = $donnees['reponse'];
                        $_SESSION['reponse'] = $reponse;    
                        
                    ?>
                            <br>
                    <br>
                    <div class="msg_success"> <!-- message pour informer l'utilisateur que les informations de son compte ont été modifiée-->
                    <p style="color:green;">Félicitation, vos informations ont été modifiées avec succès!</p>
                    </div>
                    <?php
                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                    }          
                 ?>
                </form>
        </div>
    </div>
    </section>
    <!--  Charge le footer --->
</body>
</html>